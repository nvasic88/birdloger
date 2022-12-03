<?php

namespace App\ActivityLog;

class PoachingObservationDiff
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
            'indigenous',
            'exact_number',
            'place',
            'municipality',
            'data_id',
            'folder_id',
            'file',
            'offence_details',
            'in_report',
            'case_reported',
            'case_reported_by',
            'opportunity',
            'annotation',
            'associates',
            'origin_of_individuals',
            'cites',
            'proceeding',
            'verdict',
            'verdict_date',
            'total',
            'dead_from_total',
            'alive_from_total',
            'sanction_rsd',
            'sanction_eur',
            'community_sentence',
            'sources',
            'case_against',
            'case_against_mb',
            'case_against_pib',
            'case_submitted_to',
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
            'taxon' => function ($poachingObservation) {
                $taxon = optional($poachingObservation->observation->taxon);

                return [
                    'value' => $taxon->id,
                    'label' => $taxon->name ?? $poachingObservation->taxon_suggestion,
                ];
            },
            'stage' => function ($poachingObservation) {
                $stage = optional($poachingObservation->observation->stage);

                return [
                    'value' => $stage->id,
                    'label' => $stage->name ? "stages.{$stage->name}" : null,
                ];
            },
            'sex' => function ($poachingObservation) {
                $sex = $poachingObservation->observation->sex;

                return [
                    'value' => $sex,
                    'label' => $sex ? "labels.sexes.{$sex}" : null,
                ];
            },
            'found_dead' => function ($poachingObservation) {
                return [
                    'value' => $poachingObservation->observation->found_dead,
                    'label' => $poachingObservation->observation->found_dead ? 'Yes' : 'No',
                ];
            },
            'photos' => function ($poachingObservation) {
                return [
                    'value' => $poachingObservation->observation->photos->pluck('id')->sortBy('id')->all(),
                    'label' => null,
                ];
            },
            'types' => function ($poachingObservation) {
                return [
                    'value' => $poachingObservation->observation->types->pluck('id')->sortBy('id')->all(),
                    'label' => null,
                ];
            },
            'data_license' => function ($poachingObservation) {
                $license = optional($poachingObservation->license());

                return [
                    'value' => $license->id,
                    'label' => $license->id ? 'licenses.'.$license->id : null,
                ];
            },
        ];
    }
}
