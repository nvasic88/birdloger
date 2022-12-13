<?php

namespace App\Exports\ElectrocutionObservations;

use App\ElectrocutionObservation;
use App\Export;
use App\Exports\BaseExport;
use Illuminate\Support\Collection;

class ElectrocutionObservationsExport extends BaseExport
{
    /**
     * Column labels and names.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function columnData()
    {
        return collect([
            [
                'label' => trans('labels.id'),
                'value' => 'id',
            ],
            [
                'label' => trans('labels.observations.rid'),
                'value' => 'rid',
            ],
            [
                'label' => trans('labels.observations.fid'),
                'value' => 'fid',
            ],
            [
                'label' => trans('labels.field_observations.latitude'),
                'value' => 'latitude',
            ],
            [
                'label' => trans('labels.field_observations.longitude'),
                'value' => 'longitude',
            ],
            [
                'label' => trans('labels.field_observations.day'),
                'value' => 'day',
            ],
            [
                'label' => trans('labels.field_observations.month'),
                'value' => 'month',
            ],
            [
                'label' => trans('labels.field_observations.year'),
                'value' => 'year',
            ],
            [
                'label' => trans('labels.field_observations.time'),
                'value' => 'time',
            ],
            [
                'label' => trans('labels.field_observations.taxon'),
                'value' => 'taxon',
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
            ],
            [
                'label' => trans('labels.observations.atlas_code'),
                'value' => 'atlas_code',
            ],
            [
                'label' => trans('labels.field_observations.number'),
                'value' => 'number',
            ],
            [
                'label' => trans('labels.field_observations.number_of'),
                'value' => 'number_of',
            ],
            [
                'label' => trans('labels.observations.data_provider'),
                'value' => 'data_provider',
            ],
            [
                'label' => trans('labels.observations.data_limit'),
                'value' => 'data_limit',
            ],
            [
                'label' => trans('labels.field_observations.comment'),
                'value' => 'comment',
            ],
            [
                'label' => trans('labels.field_observations.identifier'),
                'value' => 'identifier',
            ],
            [
                'label' => trans('labels.exports.observers'),
                'value' => 'observers',
            ],
            [
                'label' => trans('labels.field_observations.location'),
                'value' => 'location',
            ],
            [
                'label' => trans('labels.field_observations.mgrs10k'),
                'value' => 'mgrs10k',
            ],
            [
                'label' => trans('labels.field_observations.accuracy'),
                'value' => 'accuracy',
            ],
            [
                'label' => trans('labels.field_observations.elevation'),
                'value' => 'elevation',
            ],
            [
                'label' => trans('labels.field_observations.sex'),
                'value' => 'sex',
            ],
            [
                'label' => trans('labels.field_observations.stage'),
                'value' => 'stage',
            ],
            [
                'label' => trans('labels.field_observations.data_license'),
                'value' => 'license',
            ],
            [
                'label' => trans('labels.field_observations.note'),
                'value' => 'note',
            ],
            [
                'label' => trans('labels.field_observations.description'),
                'value' => 'description',
            ],
            [
                'label' => trans('labels.field_observations.project'),
                'value' => 'project',
            ],
            [
                'label' => trans('labels.field_observations.habitat'),
                'value' => 'habitat',
            ],
            [
                'label' => trans('labels.field_observations.found_on'),
                'value' => 'found_on',
            ],
            [
                'label' => trans('labels.electrocution_observations.found_dead'),
                'value' => 'found_dead',
            ],
            [
                'label' => trans('labels.electrocution_observations.found_dead_note'),
                'value' => 'found_dead_note',
            ],
            [
                'label' => trans('labels.field_observations.status'),
                'value' => 'status',
            ],
            [
                'label' => trans('labels.field_observations.dataset'),
                'value' => 'dataset',
             ] ,


        ]);
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
        return $columns->pipe(function ($columns) {
            if (auth()->user()->hasAnyRole(['admin', 'curator'])) {
                return $columns;
            }

            return $columns->filter(function ($column) {
                return ! in_array($column['value'], ['identifier', 'observer']);
            })->values();
        });
    }

    /**
     * Database query to get the data for export.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(Export $export)
    {
        return ElectrocutionObservation::with([
            'observation.taxon', 'observation.photos', 'observedBy', 'identifiedBy',
            'observation.types.translations', 'observation.stage',
        ])->filter($export->filter)->orderBy('id');
    }

    /**
     * Extract needed data from item.
     *
     * @param  \App\ElectrocutionObservation  $item
     * @return array
     */
    protected function transformItem($item)
    {
        $taxon = optional($item->observation->taxon);

        return [
            'id' => $item->id,
            'rid' => $item->rid,
            'fid' => $item->fid,
            'latitude' => $item->observation->latitude,
            'longitude' => $item->observation->longitude,
            'day' => $item->observation->day,
            'month' => $item->observation->month,
            'year' => $item->observation->year,
            'time' => optional($item->time)->format('H:i'),
            'taxon' => $taxon->name,
            'spid' => $taxon->spid,
            'atlas_code' => $item->observation->atlas_code,
            'number' => $item->observation->number,
            'number_of' => $item->observation->number_of_translation,
            'data_provider' => $item->observation->data_provider,
            'data_limit' => $item->observation->data_limit,
            'comment' => $item->observation->comment,
            'identifier' => $item->identifier,
            'observers' => $item->observation->observers->map(function ($observer) {
                return "{$observer->firstName} {$observer->lastName}";
            })->implode('; '),

            'location' => $item->observation->location,
            'mgrs10k' => $item->observation->mgrs10k,
            'accuracy' => $item->observation->accuracy,
            'elevation' => $item->observation->elevation,
            'sex' => $item->observation->sex_translation,
            'stage' => optional($item->observation->stage)->name_translation,
            'license' => $item->license_translation,
            'note' => $item->observation->note,
            'description' => $item->observation->description,
            'project' => $item->observation->project,
            'habitat' => $item->observation->habitat,
            'found_on' => $item->observation->found_on,
            'found_dead' => $item->observation->found_dead ? __('Yes') : __('No'),
            'found_dead_note' => $item->observation->found_dead_note,
            'status' => $item->status_translation,
            'dataset' => $item->observation->dataset,
            #'types' => $item->observation->types->pluck('name')->implode(', '),

        ];
    }
}
