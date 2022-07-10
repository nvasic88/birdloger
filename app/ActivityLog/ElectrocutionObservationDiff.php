<?php

namespace App\ActivityLog;

class ElectrocutionObservationDiff
{
    use MakesDiffs;

    /**
     * List of attributes for which we want to keep track of changes.
     *
     * @return array
     */
    protected static function attributesToDiff()
    {
        return [
            'taxon',
            'day',
            'month',
            'year',
            'location',
            'latitude',
            'longitude',
            'accuracy',
            'elevation',
            'photos',
            'sex',
            'stage',
            'number',
            'number_of',
            'note',
            'project',
            'habitat',
            'found_on',
            'found_dead',
            'found_dead_note',
            'data_license',
            'time',
            'status',
            'types',
            'observer',
            'identifier',
            'dataset',
            'atlas_code',
            'description',
            'comment',
            'data_limit',
            'data_provider',
            'rid',
            'fid',
        ];
    }

    /**
     * If we want to display the value of changed attribute differently,
     * we define a function extract it here.
     *
     * @return array
     */
    protected static function valueOverrides()
    {
        return [
            'taxon' => function ($electrocutionObservation) {
                $taxon = optional($electrocutionObservation->observation->taxon);

                return [
                    'value' => $taxon->id,
                    'label' => $taxon->name ?? $electrocutionObservation->taxon_suggestion,
                ];
            },
            'stage' => function ($electrocutionObservation) {
                $stage = optional($electrocutionObservation->observation->stage);

                return [
                    'value' => $stage->id,
                    'label' => $stage->name ? "stages.{$stage->name}" : null,
                ];
            },
            'sex' => function ($electrocutionObservation) {
                $sex = $electrocutionObservation->observation->sex;

                return [
                    'value' => $sex,
                    'label' => $sex ? "labels.sexes.{$sex}" : null,
                ];
            },
            'found_dead' => function ($electrocutionObservation) {
                return [
                    'value' => $electrocutionObservation->observation->found_dead,
                    'label' => $electrocutionObservation->observation->found_dead ? 'Yes' : 'No',
                ];
            },
            'photos' => function ($electrocutionObservation) {
                return [
                    'value' => $electrocutionObservation->observation->photos->pluck('id')->sortBy('id')->all(),
                    'label' => null,
                ];
            },
            'types' => function ($electrocutionObservation) {
                return [
                    'value' => $electrocutionObservation->observation->types->pluck('id')->sortBy('id')->all(),
                    'label' => null,
                ];
            },
            'data_license' => function ($electrocutionObservation) {
                $license = optional($electrocutionObservation->license());

                return [
                    'value' => $license->id,
                    'label' => $license->id ? 'licenses.'.$license->id : null,
                ];
            },
        ];
    }
}
