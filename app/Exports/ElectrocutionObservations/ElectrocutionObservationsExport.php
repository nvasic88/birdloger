<?php

namespace App\Exports\ElectrocutionObservations;

use App\ElectrocutionObservation;
use App\Export;
use App\Exports\BaseExport;
use Illuminate\Support\Collection;

class ElectrocutionObservationsExport extends BaseExport
{
    const DELIM = ', ';

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
                'label' => trans('labels.observations.taxon'),
                'value' => 'taxon',
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
            ],
            [
                'label' => trans('labels.observations.day'),
                'value' => 'day',
            ],
            [
                'label' => trans('labels.observations.month'),
                'value' => 'month',
            ],
            [
                'label' => trans('labels.observations.year'),
                'value' => 'year',
            ],
            [
                'label' => trans('labels.observations.location'),
                'value' => 'location',
            ],
            [
                'label' => trans('labels.observations.latitude'),
                'value' => 'latitude',
            ],
            [
                'label' => trans('labels.observations.longitude'),
                'value' => 'longitude',
            ],
            [
                'label' => trans('labels.electrocution_observations.death_cause'),
                'value' => 'death_cause',
            ],
            [
                'label' => trans('labels.electrocution_observations.found_dead_note'),
                'value' => 'found_dead_note',
            ],
            [
                'label' => trans('labels.observations.stage'),
                'value' => 'stage',
            ],
            [
                'label' => trans('labels.observations.sex'),
                'value' => 'sex',
            ],
            [
                'label' => trans('labels.observations.atlas_code'),
                'value' => 'atlas_code',
            ],
            [
                'label' => trans('labels.electrocution_observations.column_type'),
                'value' => 'column_type',
            ],
            [
                'label' => trans('labels.electrocution_observations.console_type'),
                'value' => 'console_type',
            ],
            [
                'label' => trans('labels.electrocution_observations.voltage'),
                'value' => 'voltage',
            ],
            [
                'label' => trans('labels.electrocution_observations.iba'),
                'value' => 'iba',
            ],
            [
                'label' => trans('labels.observations.number'),
                'value' => 'number',
            ],
            [
                'label' => trans('labels.observations.number_of'),
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
                'label' => trans('labels.observations.note'),
                'value' => 'note',
            ],
            [
                'label' => trans('labels.observations.habitat'),
                'value' => 'habitat',
            ],
            [
                'label' => trans('labels.electrocution_observations.time_of_corpse_found'),
                'value' => 'time_of_corpse_found',
            ],
            [
                'label' => trans('labels.electrocution_observations.duration'),
                'value' => 'duration',
            ],
            [
                'label' => trans('labels.electrocution_observations.distance_from_pillar'),
                'value' => 'distance_from_pillar',
            ],
            [
                'label' => trans('labels.electrocution_observations.pillar_number'),
                'value' => 'pillar_number',
            ],
            [
                'label' => trans('labels.electrocution_observations.age'),
                'value' => 'age',
            ],
            [
                'label' => trans('labels.electrocution_observations.position'),
                'value' => 'position',
            ],
            [
                'label' => trans('labels.electrocution_observations.state'),
                'value' => 'state',
            ],
            [
                'label' => trans('labels.observations.project'),
                'value' => 'project',
            ],
            [
                'label' => trans('labels.observations.dataset'),
                'value' => 'dataset',
            ],
            [
                'label' => trans('labels.exports.observers'),
                'value' => 'observers',
            ],
            [
                'label' => trans('labels.observations.data_license'),
                'value' => 'license',
            ],
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
            if (auth()->user()->hasAnyRole(['admin', 'electrocution'])) {
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
            'taxon' => $taxon->name,
            'spid' => $taxon->spid,
            //'date' => $item->observation->day.'.'.$item->observation->month.'.'.$item->observation->year.'.',

            'day' => $item->observation->day,
            'month' => $item->observation->month,
            'year' => $item->observation->year,

            # 'time' => optional($item->time)->format('H:i'),
            'location' => $item->observation->location,
            'latitude' => $item->observation->latitude,
            'longitude' => $item->observation->longitude,
            'death_cause' => $item->death_cause ? trans('labels.electrocution_observations.'.$item->death_cause) : null,
            'found_dead_note' => $item->observation->found_dead_note,
            'stage' => optional($item->observation->stage)->name_translation,
            'sex' => $item->observation->sex_translation,
            'atlas_code' => $item->observation->atlas_code,
            'column_type' => $item->column_type,
            'console_type' => $item->console_type,
            'voltage' => $item->voltage,
            'iba' => $item->iba,
            'number' => $item->observation->number,
            'number_of' => $item->observation->number_of_translation,
            'data_provider' => $item->observation->data_provider,
            'data_limit' => $item->observation->data_limit,
            'note' => $item->observation->note,
            'habitat' => $item->observation->habitat,
            'time_of_corpse_found' => optional($item->time_of_corpse_found)->format('H:i'),
            'duration' => $item->duration,
            'distance_from_pillar' => $item->distance_from_pillar,
            'pillar_number' => $item->pillar_number,
            'age' => $item->age,
            'position' => $item->position ? trans('labels.electrocution_observations.'.$item->position) : null,
            'state' => $item->state ? trans('labels.electrocution_observations.'.$item->state) : null,
            'project' => $item->observation->project,
            'dataset' => $item->observation->dataset,
            'observers' => $item->observation->observers->map(function ($observer) {
                return "{$observer->name}";
            })->implode(self::DELIM),
            'license' => $item->license_translation,
        ];
    }
}
