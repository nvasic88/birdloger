<?php

namespace App\Exports;

use App\Export;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\WriterInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Localizable;

abstract class BaseExport
{
    use Localizable;

    /**
     * Create export model.
     *
     * @param  array  $columns
     * @param  array  $filter
     * @param  bool  $withHeader
     * @return \App\Export
     */
    public static function create(array $columns, array $filter, $withHeader = false)
    {
        return Export::create([
            'type' => static::class,
            'filter' => collect($filter),
            'user_id' => auth()->id(),
            'filename' => Str::random().'.xlsx',
            'status' => ExportStatus::QUEUED,
            'columns' => $columns,
            'locale' => app()->getLocale(),
            'with_header' => $withHeader,
        ]);
    }

    /**
     * Column labels and names.
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public static function columnData();


    /**
     * Get list of columns available for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function availableColumns()
    {
        return static::availableColumnData()->pluck('value');
    }

    /**
     * Modified collection of available columns' data.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function availableColumnData()
    {
        return static::columnData()->pipe(function ($columns) {
            return static::modifyAvailableColumns($columns);
        });
    }

    /**
     * Perform aditional modifications to available columns if needed.
     * F.e. filter out available columns based on permissions.
     *
     * @param  \Illuminate\Support\Collection  $columns
     * @return \Illuminate\Support\Collection
     */
    protected static function modifyAvailableColumns(Collection $columns)
    {
        return $columns;
    }

    /**
     * Perform the export.
     *
     * @param  \App\Export  $export
     * @return void
     */
    public function export(Export $export)
    {
        $this->withLocale($export->preferredLocale(), function () use ($export) {
            $export->updateStatusToExporting();

            try {
                $export->moveToFinalPath($this->exportToTempFile($export));

                $export->updateStatusToFinished();
            } catch (\Exception $e) {
                $export->updateStatusToFailed();

                throw $e;
            }
        });
    }

    /**
     * Get XLSX writer instance.
     *
     * @param string $path
     * @return \Box\Spout\Writer\WriterInterface
     * @throws \Box\Spout\Common\Exception\IOException
     */
    private function makeWriter($path)
    {
        return WriterEntityFactory::createXLSXWriter()->openToFile($path);
    }

    /**
     * Get path to temp file.
     *
     * @return string
     */
    private function tempFilePath()
    {
        $path = 'exports/'.Str::random();

        // Make sure the file exists
        Storage::put($path, null);

        return Storage::path($path);
    }

    /**
     * Export data to temp file.
     *
     * @param  \App\Export  $export
     * @return string temp file path
     */
    private function exportToTempFile(Export $export)
    {
        $tempFilePath = $this->tempFilePath();
        $writer = $this->makeWriter($tempFilePath);

        $this->writeHeader($export, $writer);
        $this->writeContents($export, $writer);

        $writer->close();

        return $tempFilePath;
    }

    /**
     * Write the export header.
     *
     * @param  \App\Export  $export
     * @param  \Box\Spout\Writer\WriterInterface  $writer
     * @return void
     */
    private function writeHeader(Export $export, WriterInterface $writer)
    {
        if ($export->with_header) {
            $writer->addRow($this->getHeaderForColumns($export->columns));
        }
    }

    /**
     * Get header labels for given columns in the order of columns.
     *
     * @param  array  $columns
     * @return \Box\Spout\Common\Entity\Row
     */
    private function getHeaderForColumns(array $columns)
    {
        $columnLabels = static::columnData()->mapWithKeys(function ($column) {
            return [$column['value'] => $column['label']];
        });

        return WriterEntityFactory::createRowFromArray(array_map(function ($column) use ($columnLabels) {
            return $columnLabels->get($column);
        }, $columns));
    }

    /**
     * Write the contents of the exported file.
     *
     * @param  \App\Export  $export
     * @param  \Box\Spout\Writer\WriterInterface  $writer
     * @return void
     */
    private function writeContents(Export $export, WriterInterface $writer)
    {
        $this->query($export)->chunk(300, function ($items) use ($export, $writer) {
            $items->each(function ($item) use ($export, $writer) {
                $row = WriterEntityFactory::createRowFromArray($this->takeColumns(
                    $this->transformItem($item),
                    $export->columns
                ));
                $writer->addRow($row);
            });
        });
    }

    /**
     * Database query to get the data for export.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    abstract protected function query(Export $export);

    /**
     * Extract needed data from item.
     *
     * @param  mixed  $item
     * @return array
     */
    abstract protected function transformItem($item);

    /**
     * Map data to columns in the order the columns are given.
     * @param  array  $data
     * @param  array  $columns
     * @return array
     */
    private function takeColumns(array $data, $columns)
    {
        return array_map(function ($column) use ($data) {
            return Arr::get($data, $column);
        }, $columns);
    }
}
