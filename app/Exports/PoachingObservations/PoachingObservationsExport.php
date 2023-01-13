<?php

namespace App\Exports\PoachingObservations;

use App\Cites;
use App\Export;
use App\Exports\BaseExport;
use App\OffenceCase;
use App\PoachingObservation;
use App\Proceedings;
use Illuminate\Support\Collection;

class PoachingObservationsExport extends BaseExport
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
                'label' => trans('labels.poaching_observations.case_name'),
                'value' => 'case_name',
            ],
            [
                'label' => trans('labels.observations.stage'),
                'value' => 'stage',
            ],
            [
                'label' => trans('labels.observations.sex'),
                'value' => 'sex',
            ],
            /*
            [
                'label' => trans('labels.observations.types'),
                'value' => 'types',
            ],
            */
            [
                'label' => trans('labels.observations.atlas_code'),
                'value' => 'atlas_code',
            ],
            [
                'label' => trans('labels.poaching_observations.total'),
                'value' => 'total',
            ],
            [
                'label' => trans('labels.poaching_observations.dead_from_total'),
                'value' => 'dead_from_total',
            ],
            [
                'label' => trans('labels.poaching_observations.alive_from_total'),
                'value' => 'alive_from_total',
            ],
            [
                'label' => trans('labels.poaching_observations.exact_number'),
                'value' => 'exact_number',
            ],
            [
                'label' => trans('labels.poaching_observations.indigenous'),
                'value' => 'indigenous',
            ],
            [
                'label' => trans('labels.poaching_observations.offences'),
                'value' => 'offences',
            ],
            [
                'label' => trans('labels.poaching_observations.locality'),
                'value' => 'locality',
            ],
            [
                'label' => trans('labels.poaching_observations.place'),
                'value' => 'place',
            ],
            [
                'label' => trans('labels.poaching_observations.municipality'),
                'value' => 'municipality',
            ],
            [
                'label' => trans('labels.poaching_observations.data_id'),
                'value' => 'data_id',
            ],
            [
                'label' => trans('labels.poaching_observations.folder_id'),
                'value' => 'folder_id',
            ],
            [
                'label' => trans('labels.poaching_observations.file'),
                'value' => 'file',
            ],
            [
                'label' => trans('labels.poaching_observations.in_report'),
                'value' => 'in_report',
            ],
            [
                'label' => trans('labels.poaching_observations.offence_details'),
                'value' => 'offence_details',
            ],
            [
                'label' => trans('labels.poaching_observations.case_reported'),
                'value' => 'case_reported',
            ],
            [
                'label' => trans('labels.poaching_observations.case_reported_by'),
                'value' => 'case_reported_by',
            ],
            [
                'label' => trans('labels.poaching_observations.verdict'),
                'value' => 'verdict',
            ],
            [
                'label' => trans('labels.poaching_observations.verdict_date'),
                'value' => 'verdict_date',
            ],
            [
                'label' => trans('labels.poaching_observations.sanction_rsd'),
                'value' => 'sanction_rsd',
            ],
            [
                'label' => trans('labels.poaching_observations.sanction_eur'),
                'value' => 'sanction_eur',
            ],
            [
                'label' => trans('labels.poaching_observations.community_sentence'),
                'value' => 'community_sentence',
            ],
            [
                'label' => trans('labels.poaching_observations.case_submitted_to'),
                'value' => 'case_submitted_to',
            ],
            [
                'label' => trans('labels.poaching_observations.case_against'),
                'value' => 'case_against',
            ],
            [
                'label' => trans('labels.poaching_observations.case_against_mb'),
                'value' => 'case_against_mb',
            ],
            [
                'label' => trans('labels.poaching_observations.case_against_pib'),
                'value' => 'case_against_pib',
            ],
            [
                'label' => trans('labels.poaching_observations.proceeding'),
                'value' => 'proceeding',
            ],
            [
                'label' => trans('labels.poaching_observations.opportunity'),
                'value' => 'opportunity',
            ],
            [
                'label' => trans('labels.poaching_observations.annotation'),
                'value' => 'annotation',
            ],
            [
                'label' => trans('labels.poaching_observations.cites'),
                'value' => 'cites',
            ],
            [
                'label' => trans('labels.poaching_observations.origin_of_individuals'),
                'value' => 'origin_of_individuals',
            ],
            [
                'label' => trans('labels.poaching_observations.suspects'),
                'value' => 'suspects',
            ],
            [
                'label' => trans('labels.poaching_observations.sources'),
                'value' => 'sources',
            ],
            [
                'label' => trans('labels.observations.observers'),
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
     * @param \Illuminate\Support\Collection $columns
     * @return \Illuminate\Support\Collection
     */
    protected static function modifyAvailableColumns(Collection $columns)
    {
        return $columns->pipe(function ($columns) {
            if (auth()->user()->hasAnyRole(['admin', 'poaching'])) {
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
     * @param \App\Export $export
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(Export $export)
    {
        return PoachingObservation::with([
            'observation.taxon', 'observation.photos', 'observedBy', 'identifiedBy',
            'observation.types.translations', 'observation.stage',
        ])->filter($export->filter)->orderBy('id');
    }

    /**
     * Extract needed data from item.
     *
     * @param \App\PoachingObservation $item
     * @return array
     */
    protected function transformItem($item)
    {
        $taxon = optional($item->observation->taxon);

        return [
            'id' => $item->id,
            'taxon' => $taxon->name,
            'spid' => $taxon->spid,
            'day' => $item->observation->day,
            'month' => $item->observation->month,
            'year' => $item->observation->year,
            'location' => $item->observation->location,
            'latitude' => $item->observation->latitude,
            'longitude' => $item->observation->longitude,
            'case_name' => $item->case_name,
            'stage' => optional($item->observation->stage)->name_translation,
            'sex' => $item->observation->sex_translation,
            'types' => $item->observation->types->pluck('name')->implode(self::DELIM),
            'atlas_code' => $item->observation->atlas_code,
            'total' => $item->total,
            'dead_from_total' => $item->dead_from_total,
            'alive_from_total' => $item->alive_from_total,
            'exact_number' => $item->exact_number ? __('Yes') : __('No'),
            'indigenous' => $item->indigenous ? __('Yes') : __('No'),
            'locality' => $item->locality,
            'place' => $item->place,
            'municipality' => $item->municipality,
            'data_id' => $item->data_id,
            'folder_id' => $item->folder_id,
            'file' => $item->file,
            'in_report' => $item->in_report ? __('Yes') : __('No'),
            'offence_details' => $item->offence_details,
            'case_reported' => $item->case_reported ? __('Yes') : __('No'),
            'case_reported_by' => $item->case_reported_by,
            'verdict' => $this->getVerdict($item->verdict),
            'verdict_date' => optional($item->verdict_date)->toDateString(),
            'sanction_rsd' => $item->sanction_rsd,
            'sanction_eur' => $item->sanction_eur,
            'community_sentence' => $item->community_sentence,
            'case_submitted_to' => $item->case_submitted_to,
            'case_against' => $this->getCaseName($item->case_against),
            'case_against_mb' => $this->getMB($item),
            'case_against_pib' => $this->getPIB($item),
            'proceeding' => Proceedings::getNameTranslationAttribute($item->proceeding),
            'opportunity' => $item->opportunity ? __('Yes') : __('No'),
            'annotation' => $item->annotation,
            'cites' => Cites::getNameTranslationAttribute($item->cites),
            'origin_of_individuals' => $item->origin_of_individuals,


            'offences' => $item->offences->map(function ($offence) {
                return OffenceCase::getNameTranslationAttribute($offence->name);
            })->implode(self::DELIM),
            'observers' => $item->observation->observers->map(function ($observer) {
                return "{$observer->name}";
            })->implode(self::DELIM),
            #TODO: edit
            'sources' => $item->sources->map(function ($source) {
                # return 'Has yet to be implemented';
                return json_encode($source); # __('labels.poaching_observations.'.$source->name);
            })->implode(self::DELIM),
            #TODO: edit
            'suspects' => $item->suspects->map(function ($suspect) {
                # return 'Has yet to be implemented';
                return json_encode($suspect); #"{$suspect->name}";
            })->implode(self::DELIM),
            'license' => $item->license_translation,
        ];
    }

    private function getCaseName($case_against)
    {
        return __('labels.poaching_observations.'.$case_against);
    }

    private function getPIB($item)
    {
        if ($item->case_against === 'legal_entity') {
            return $item->case_against_pib;
        }
    }

    private function getMB($item)
    {
        if ($item->case_against === 'individual') {
            return $item->case_against_mb;
        }
    }

    private function getVerdict($verdict)
    {
        return __('labels.verdicts.'.$verdict);
    }
}
