<?php

namespace App\Importing;

use App\AtlasCode;
use App\Cites;
use App\DEM\Reader as DEMReader;
use App\License;
use App\NumberOf;
use App\Observation;
use App\Observer;
use App\OffenceCase;
use App\PoachingObservation;
use App\Proceedings;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\InCaseInsensitive;
use App\Rules\Month;
use App\Sex;
use App\Source;
use App\Stage;
use App\Support\Dataset;
use App\Suspect;
use App\Taxon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PoachingObservationImport extends BaseImport
{
    const DELIM = ', ';

    /**
     * @var \App\DEM\Reader
     */
    protected $demReader;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\App\Stage[]|null
     */
    protected $stages;

    /**
     * Create new importer instance.
     *
     * @param  \App\Import  $import
     * @param  \App\DEM\Reader  $demReader
     * @return void
     */
    public function __construct($import, DEMReader $demReader)
    {
        parent::__construct($import);

        $this->setDEMReader($demReader);
    }

    /**
     * Set DEM reader instance to get missing elevation.
     *
     * @param  \App\DEM\Reader  $demReader
     * @return self
     */
    public function setDEMReader(DEMReader $demReader)
    {
        $this->demReader = $demReader;

        return $this;
    }

    /**
     * Definition of all calumns with their labels.
     *
     * @param  \App\User|null  $user
     * @return \Illuminate\Support\Collection
     */
    public static function columns($user = null)
    {
        $offence_cases = collect(OffenceCase::labels());

        return collect([
            [
                'label' => trans('labels.id'),
                'value' => 'id',
                'required' => true,
            ],
            [
                'label' => trans('labels.observations.taxon'),
                'value' => 'taxon',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.day'),
                'value' => 'day',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.month'),
                'value' => 'month',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.year'),
                'value' => 'year',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.location'),
                'value' => 'location',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.latitude'),
                'value' => 'latitude',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.longitude'),
                'value' => 'longitude',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_name'),
                'value' => 'case_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.stage'),
                'value' => 'stage',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.sex'),
                'value' => 'sex',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.atlas_code'),
                'value' => 'atlas_code',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.total'),
                'value' => 'total',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.dead_from_total'),
                'value' => 'dead_from_total',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.alive_from_total'),
                'value' => 'alive_from_total',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.exact_number'),
                'value' => 'exact_number',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.indigenous'),
                'value' => 'indigenous',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.offences'),
                'value' => 'offences',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.locality'),
                'value' => 'locality',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.place'),
                'value' => 'place',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.municipality'),
                'value' => 'municipality',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.data_id'),
                'value' => 'data_id',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.folder_id'),
                'value' => 'folder_id',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.file'),
                'value' => 'file',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.in_report'),
                'value' => 'in_report',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.offence_details'),
                'value' => 'offence_details',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_reported'),
                'value' => 'case_reported',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_reported_by'),
                'value' => 'case_reported_by',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.verdict'),
                'value' => 'verdict',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.verdict_date'),
                'value' => 'verdict_date',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.sanction_rsd'),
                'value' => 'sanction_rsd',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.sanction_eur'),
                'value' => 'sanction_eur',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.community_sentence'),
                'value' => 'community_sentence',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_submitted_to'),
                'value' => 'case_submitted_to',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_against'),
                'value' => 'case_against',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_against_mb'),
                'value' => 'case_against_mb',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.case_against_pib'),
                'value' => 'case_against_pib',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.proceeding'),
                'value' => 'proceeding',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.opportunity'),
                'value' => 'opportunity',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.annotation'),
                'value' => 'annotation',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.cites'),
                'value' => 'cites',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.origin_of_individuals'),
                'value' => 'origin_of_individuals',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.suspects'),
                'value' => 'suspects',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.sources'),
                'value' => 'sources',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.observers'),
                'value' => 'observers',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.data_license'),
                'value' => 'license',
                'required' => false,
            ],

            /*
            [
                'label' => trans('labels.poaching_observations.suspect_profile'),
                'value' => 'suspect_profile',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.annotation'),
                'value' => 'annotation1',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.sources'),
                'value' => 'sources',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.facebook'),
                'value' => 'facebook',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.youtube'),
                'value' => 'youtube',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.media'),
                'value' => 'media',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.ads'),
                'value' => 'ads',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.institutions'),
                'value' => 'institutions',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.associates'),
                'value' => 'associates',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.cites'),
                'value' => 'cites',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.origin_of_individuals'),
                'value' => 'origin_of_individuals',
                'required' => false,
            ],
            [
                'label' => trans('labels.exports.observers'),
                'value' => 'observers',
                'required' => false,
            ],
             */

        ])->pipe(function ($columns) use ($user) {
            if (! $user || optional($user)->hasAnyRole(['admin', 'curator'])) {
                return $columns;
            }

            return $columns->filter(function ($column) {
                return ! in_array($column['value'], ['identifier', 'observers']);
            })->values();
        });
    }

    /**
     * Get validation rules specific for import type.
     *
     * @return array
     */
    public static function specificValidationRules()
    {
        return [
            'options.approve_curated' => ['nullable', 'boolean'],
        ];
    }

    public function generateErrorsRoute()
    {
        return route('api.poaching-observation-imports.errors', $this->model());
    }

    /**
     * Make validator instance.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function makeValidator(array $data)
    {
        return Validator::make($data, [
            'id' => ['integer'],
            'taxon' => [
                'required',
                'string',
            ],
            'year' => ['bail', 'date_format:Y', 'nullable', 'before_or_equal:now'],
            'month' => [
                'bail',
                'nullable',
                new Month(Arr::get($data, 'year')),
            ],
            'day' => [
                'bail',
                'nullable',
                new Day(Arr::get($data, 'year'), Arr::get($data, 'month')),
            ],
            'latitude' => ['nullable', new Decimal(['min' => -90, 'max' => 90])],
            'longitude' => ['nullable', new Decimal(['min' => -180, 'max' => 180])],
            'location' => ['nullable'],
            'sex' => ['nullable', Rule::in(Sex::options())],
            'stage' => ['nullable', Rule::in($this->stagesTranslatedNames())],
            'atlas_code' => ['nullable', 'integer', Rule::in(AtlasCode::CODES)],
            'total' => ['nullable'],
            'dead_from_total' => ['nullable'],
            'alive_from_total' => ['nullable'],
            'exact_number' => ['nullable', 'string', new InCaseInsensitive($this->yesNo())],
            'indigenous' => ['required', 'string', new InCaseInsensitive($this->yesNo())],
            'offences' => ['nullable'],
            'locality' => ['nullable'],
            'place' => ['nullable'],
            'municipality' => ['nullable'],
            'data_id' => ['nullable'],
            'folder_id' => ['nullable'],
            'file' => ['nullable'],
            'in_report' => ['string', 'required', new InCaseInsensitive($this->yesNo())],
            'offence_details' => ['nullable', 'string'],
            'case_reported' => ['string', 'required', new InCaseInsensitive($this->yesNo())],
            'case_reported_by' => ['nullable', 'string'],
            'verdict' => ['nullable', new InCaseInsensitive($this->yesNoRejected())],
            'verdict_date' => ['nullable'],
            'sanction_rsd' => ['nullable'],
            'sanction_eur' => ['nullable'],
            'community_sentence' => ['nullable'],
            'case_against' => ['nullable'],
            'case_against_mb' => ['nullable'],
            'case_against_pib' => ['nullable'],
            'proceeding' => ['nullable'],
            'opportunity' => ['nullable', 'string', new InCaseInsensitive($this->yesNo())],
            'annotation' => ['nullable', 'string'],
            'cites' => ['nullable', Rule::in(Cites::options())],
            'origin_of_individuals' => ['nullable', 'string'],
            'suspects' => ['nullable'],
            'sources' => ['nullable'],
            'observers' => ['nullable'],
            'license' => ['nullable', 'string', Rule::in(array_values(License::getOptions()))],

            #'facebook' => ['nullable', 'string'],
            #'institutions' => ['nullable', 'string'],
            #'associates' => ['nullable', 'string'],
            #'youtube' => ['nullable', 'string'],
            #'social_media' => ['nullable', 'string'],
            #'ads' => ['nullable', 'string'],
            #'accuracy' => ['nullable'],
            #'date' => ['nullable'],
            #'input_date' => ['nullable'],
            #'annotation1' => ['nullable', 'string'],
            #'suspect_profile' => ['nullable', 'string'],
            #'suspect_number' => ['nullable', 'numeric'],
            #'suspect_place' => ['nullable', 'string'],
            #'suspect_name' => ['nullable', 'string'],


        ], [
            'year.date_format' => trans('validation.year'),
            'sex.in' => __('validation.in_extended', [
                'attribute' => __('labels.observations.sex'),
                'options' => Sex::labels()->implode(', '),
            ]),
            'stage.in' => __('validation.in_extended', [
                'attribute' => __('labels.observations.stage'),
                'options' => $this->stagesTranslatedNames()->implode(', '),
            ]),
        ], [
            'id' => trans('labels.observations.id'),
            'data_id' => trans('labels.poaching_observations.data_id'),
            'folder_id' => trans('labels.poaching_observations.folder_id'),
            'file' => trans('labels.poaching_observations.file'),
            'in_report' => trans('labels.poaching_observations.in_report'),
            'locality' => trans('labels.poaching_observations.locality'),
            'municipality' => trans('labels.poaching_observations.municipality'),
            'place' => trans('labels.poaching_observations.place'),
            'latitude' => trans('labels.observations.latitude'),
            'longitude' => trans('labels.observations.longitude'),

            'day' => trans('labels.observations.day'),
            'month' => trans('labels.observations.month'),
            'year' => trans('labels.observations.year'),
            'taxon' => trans('labels.observations.taxon'),
            'license' => trans('labels.observations.data_license'),
            'indigenous' => trans('labels.poaching_observations.indigenous'),
            'total' => trans('labels.poaching_observations.total'),
            'dead_from_total' => trans('labels.poaching_observations.dead_from_total'),
            'alive_from_total' => trans('labels.poaching_observations.alive_from_total'),
            'exact_number' => trans('labels.poaching_observations.exact_number'),
            'offences' => trans('labels.poaching_observations.offences'),
            'offence_details' => trans('labels.poaching_observations.offence_details'),
            'case_reported' => trans('labels.poaching_observations.case_reported'),
            'case_reported_by' => trans('labels.poaching_observations.case_reported_by'),
            'verdict' => trans('labels.poaching_observations.verdict'),
            'verdict_date' => trans('labels.poaching_observations.verdict_date'),
            'proceeding' => trans('labels.poaching_observations.proceeding'),
            'sanction_rsd' => trans('labels.poaching_observations.sanction_rsd'),
            'sanction_eur' => trans('labels.poaching_observations.sanction_eur'),
            'community_sentence' => trans('labels.poaching_observations.community_sentence'),
            'opportunity' => trans('labels.poaching_observations.opportunity'),
            'annotation' => trans('labels.poaching_observations.annotation'),

            'sources' => trans('labels.poaching_observations.sources'),
            'cites' => trans('labels.poaching_observations.cites'),
            'origin_of_individuals' => trans('labels.poaching_observations.origin_of_individuals'),
            'observers' => trans('labels.observations.observers'),

            'location' => trans('labels.observations.location'),
            'sex' => trans('labels.observations.sex'),
            'stage' => trans('labels.observations.stage'),
            'atlas_code' => trans('labels.observations.atlas_code'),
            'case_against' => trans('labels.poaching_observations.case_against'),
            'case_against_mb' => trans('labels.poaching_observations.case_against_mb'),
            'case_against_pib' => trans('labels.poaching_observations.case_against_pib'),
            'suspects' => trans('labels.poaching_observations.suspects'),

        ]);
    }

    /**
     * "Yes" and "No" options translated in language the import is using.
     *
     * @return array
     */
    protected function yesNo()
    {
        $lang = $this->model()->lang;

        return [__('Yes', [], $lang), __('No', [], $lang)];
    }

    /**
     * "Yes", "No", "Rejected" options translated in language the import is using.
     *
     * @return array
     */
    protected function yesNoRejected()
    {
        $lang = $this->model()->lang;

        return [__('Yes', [], $lang), __('No', [], $lang), __('Rejected', [], $lang)];
    }

    /**
     * Store data from single XLSX row.
     *
     * @param  array  $item
     * @return void
     */
    protected function storeSingleItem(array $item)
    {
        $poachingObservation = PoachingObservation::create(
            $this->getSpecificObservationData($item)
        );

        $observation = $poachingObservation->observation()->save(
            new Observation($this->getGeneralObservationData($item))
        );

        $poachingObservation->observation->observers()->sync($this->getObservers($item), []);
        $poachingObservation->offences()->sync($this->getOffences($item), []);

        $this->createSources($item, $poachingObservation);
        $this->createSuspects($item, $poachingObservation);

        #TODO: Temporary available until majority of observations are imported..
        $poachingObservation->approve();

        activity()->performedOn($poachingObservation)
            ->causedBy($this->model()->user)
            ->log('created');

        if ($observation->isApproved()) {
            activity()->performedOn($poachingObservation)
                ->causedBy($this->model()->user)
                ->log('approved');
        }
    }

    /**
     * Get observation data specific to poaching observation from the request.
     *
     * @param  array  $item
     * @return array
     */
    protected function getSpecificObservationData(array $item)
    {
        $total = $this->convertToNumberOrNull(Arr::get($item, 'total') ?: null);
        $dead_from_alive = $this->convertToNumberOrNull(Arr::get($item, 'dead_from_total') ?: null);
        $alive_from_total = $this->convertToNumberOrNull(Arr::get($item, 'alive_from_total') ?: null);
        $case_against_mb = $this->convertToNumberOrNull(Arr::get($item, 'case_against_mb') ?: null);
        $case_against_pib = $this->convertToNumberOrNull(Arr::get($item, 'case_against_pib') ?: null);
        $case_against = $this->getCaseAgainst(Arr::get($item, 'case_against'));

        return [
            # 'license' => Arr::get($item, 'data_license') ?: $this->model()->user->settings()->get('data_license'),
            'taxon_suggestion' => Arr::get($item, 'taxon') ?: null,
            # 'observed_by_id' => $this->getObserverId($item),
            'identified_by_id' => $this->getIdentifierId($item),
            'license' => $this->getLicense($item),

            'case_name' => Arr::get($item, 'case_name') ?: null,
            'total' => $total,
            'dead_from_total' => $dead_from_alive,
            'alive_from_total' => $alive_from_total,
            'exact_number' => $this->getBoolean($item, 'exact_number'),
            'indigenous' => $this->getBoolean($item, 'indigenous'),
            'locality' => Arr::get($item, 'locality') ?: null,
            'place' => Arr::get($item, 'place') ?: null,
            'municipality' => Arr::get($item, 'municipality') ?: null,

            'data_id' => Arr::get($item, 'data_id') ?: null,
            'folder_id' => Arr::get($item, 'folder_id') ?: null,
            'file' => Arr::get($item, 'file') ?: null,
            'in_report' => $this->getBoolean($item, 'in_report'),
            'offence_details' => Arr::get($item, 'offence_details') ?: null,
            'case_reported' => $this->getBoolean($item, 'case_reported'),
            'case_reported_by' => Arr::get($item, 'case_reported_by') ?: null,
            'verdict' => $this->getVerdict($item, 'verdict'),
            'verdict_date' => Arr::get($item, 'verdict_date') ?: null,
            'sanction_rsd' => Arr::get($item, 'sanction_rsd') ?: null,
            'sanction_eur' => Arr::get($item, 'sanction_eur') ?: null,
            'community_sentence' => Arr::get($item, 'community_sentence') ?: null,
            'case_submitted_to' => Arr::get($item, 'case_submitted_to') ?: null,
            'case_against' => $case_against,
            'case_against_mb' => $case_against_mb,
            'case_against_pib' => $case_against_pib,
            'proceeding' => Proceedings::getValueFromLabel(Arr::get($item, 'proceeding')),
            'opportunity' => $this->getBoolean($item, 'opportunity'),
            'annotation' => Arr::get($item, 'annotation') ?: null,
            'cites' => Cites::getValueFromLabel(Arr::get($item, 'cites')),
            'origin_of_individuals' => Arr::get($item, 'origin_of_individuals') ?: null,
        ];
    }

    /**
     * Get general observation data from the request.
     *
     * @param  array  $item
     * @return array
     */
    protected function getGeneralObservationData(array $item)
    {
        $latitude = $this->getLatitude($item);
        $longitude = $this->getLongitude($item);
        $taxon = $this->getTaxon($item);
        $atlasCode = Arr::get($item, 'atlas_code');
        $day = $this->convertToNumberOrNull(Arr::get($item, 'day') ?: null);
        $month = $this->convertToNumberOrNull(Arr::get($item, 'month') ?: null);
        #$accuracy = $this->convertAccuracy($item);

        return [
            'taxon_id' => $taxon ? $taxon->id : null,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'day' => $day,
            'month' => $month,
            'year' => Arr::get($item, 'year') ?: null,
            'location' => Arr::get($item, 'location') ?: null,
            #'accuracy' => $accuracy,
            'created_by_id' => $this->model()->for_user_id ?: $this->model()->user_id,
            # 'observer' => $this->getObserver($item),
            'identifier' => $this->getIdentifier($item),
            'stage_id' => $this->getStageId($item),
            # 'original_identification' => Arr::get($item, 'original_identification', Arr::get($item, 'taxon')),
            'original_identification' => Arr::get($item, 'taxon'),
            'dataset' => Arr::get($item, 'dataset') ?? Dataset::default(),
            'approved_at' => $this->getApprovedAt($taxon),
            #'number_of' => Arr::get($item, 'number_of') ?: null,
            'number_of' => NumberOf::getValueFromLabel(Arr::get($item, 'number_of', '')),
            'comment' => Arr::get($item, 'comment') ?: null,
            'data_provider' => Arr::get($item, 'data_provider') ?: null,
            'data_limit' => Arr::get($item, 'data_limit') ?: null,
            'description' => Arr::get($item, 'description') ?: null,
            'atlas_code' => $atlasCode === '' ? null : (int) $atlasCode,
            'found_dead' => $this->getFoundDead($item),
            'found_dead_note' => $this->getFoundDead($item) ? Arr::get($item, 'found_dead_note') : null,
            'sex' => Sex::getValueFromLabel(Arr::get($item, 'sex', '')),
        ];
    }

    /**
     * Get ID of taxon using it's name.
     *
     * @param  array  $data
     * @return Taxon|null
     */
    protected function getTaxon(array $data)
    {
        $name = explode(' ', Arr::get($data, 'taxon'));
        if ($name == []) {
            return;
        }

        return Taxon::findByName($name[0].' '.$name[1]);
    }

    /**
     * Get latitude.
     *
     * @param  array  $data
     * @return float
     */
    protected function getLatitude(array $data)
    {
        return (float) str_replace(',', '.', Arr::get($data, 'latitude'));
    }

    /**
     * Get longitude.
     *
     * @param  array  $data
     * @return float
     */
    protected function getLongitude(array $data)
    {
        return (float) str_replace(',', '.', Arr::get($data, 'longitude'));
    }

    /**
     * Get elevation.
     *
     * @param array $data
     * @return int|string|null
     */
    protected function getElevation(array $data)
    {
        $elevation = Arr::get($data, 'elevation');

        if (is_numeric($elevation)) {
            return $elevation;
        }

        if ($this->demReader) {
            return $this->demReader->getElevation(
                $this->getLatitude($data),
                $this->getLongitude($data)
            );
        }
    }

    /**
     * Get observer name.
     *
     * @param  array  $data
     * @return string|null
     */
    protected function getObserver(array $data)
    {
        if (! $this->model()->user->hasAnyRole(['admin', 'curator'])) {
            return $this->model()->user->full_name;
        }

        return Arr::get($data, 'observer') ?: $this->model()->user->full_name;
    }

    /**
     * Get observer ID.
     *
     * @param  array  $data
     * @return int
     */
    protected function getObserverId(array $data)
    {
        if ($this->shouldUseCurrentUserId(Arr::get($data, 'observer'))) {
            return $this->model()->user->id;
        }
    }

    /**
     * Get identifier name.
     *
     * @param  array  $data
     * @return string|null
     */
    protected function getIdentifier(array $data)
    {
        if (! $this->model()->user->hasAnyRole(['admin', 'curator'])) {
            return $this->model()->user->full_name;
        }

        return Arr::get($data, 'identifier') ?: $this->model()->user->full_name;
    }

    /**
     * Get identifier ID.
     *
     * @param  array  $data
     * @return int
     */
    protected function getIdentifierId(array $data)
    {
        if ($this->shouldUseCurrentUserId(Arr::get($data, 'identifier'))) {
            return $this->model()->user->id;
        }
    }

    /**
     * Check if the name matches current user.
     *
     * @param  string|null  $name
     * @return bool
     */
    private function shouldUseCurrentUserId($name = null)
    {
        return ! $this->model()->user->hasAnyRole(['admin', 'curator']) || ! $name;
    }

    /**
     * Get all the stages.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function stages()
    {
        if (! $this->stages) {
            $this->stages = Stage::all();
        }

        return $this->stages;
    }

    /**
     * Get correctly translated stages' names.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function stagesTranslatedNames()
    {
        return $this->stages()->pluck('name_translation');
    }

    /**
     * Get stage ID.
     *
     * @param  array  $data
     * @return int|null
     */
    protected function getStageId(array $data)
    {
        $translation = strtolower(Arr::get($data, 'stage', ''));

        $stage = $this->stages()->first(function ($stage) use ($translation) {
            return strtolower($stage->name_translation) === $translation;
        });

        return $stage ? $stage->id : null;
    }

    /**
     * Get value for "Found Dead" field.
     *
     * @param  array  $data
     * @return bool
     */
    protected function getFoundDead(array $data)
    {
        $value = Arr::get($data, 'found_dead', false);

        return $this->isTranslatedYes($value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Check if the value matches with "Yes" translation.
     *
     * @param string $value
     * @return bool
     */
    protected function isTranslatedYes($value)
    {
        if (! is_string($value)) {
            return false;
        }

        $yes = __('Yes', [], $this->model()->lang);

        return strtolower($yes) === strtolower($value);
    }

    /**
     * Check if the value matches with "Yes" translation.
     *
     * @param string $value
     * @return bool
     */
    protected function isTranslatedNo($value)
    {
        if (! is_string($value)) {
            return false;
        }

        $no = __('No', [], $this->model()->lang);

        return strtolower($no) === strtolower($value);
    }

    /**
     * Check if the value matches with "Rejected" translation.
     *
     * @param string $value
     * @return bool
     */
    protected function isTranslatedRejected($value)
    {
        if (! is_string($value)) {
            return false;
        }

        $rejected = __('Rejected', [], $this->model()->lang);

        return strtolower($rejected) === strtolower($value);
    }

    /**
     * Get license for the observation.
     *
     * @param  array  $data
     * @return int
     */
    protected function getLicense(array $data)
    {
        return License::getValueFromLabel(Arr::get($data, 'license')) ?: $this->model()->user->settings()->get('data_license');
    }

    /**
     * Get `approved_at` attribute for the observation.
     *
     * @param Taxon|null $taxon
     * @return \Carbon\Carbon|null
     */
    protected function getApprovedAt($taxon)
    {
        return $this->shouldApprove($taxon) ? now() : null;
    }

    /**
     * Check if we should automatically approve observation of given taxon.
     *
     * @param Taxon|null $taxon
     * @return bool
     */
    protected function shouldApprove($taxon)
    {
        return $this->shouldApproveCurated() &&
            $this->model()->user->hasRole('curator') &&
            $taxon && $taxon->canBeApprovedBy($this->model()->user);
    }

    /**
     * Check if option to verify observations of curated taxa is selected.
     *
     * @return bool
     */
    protected function shouldApproveCurated()
    {
        return $this->model()->options['approve_curated'] ?? false;
    }

    protected function getOffences(array $item)
    {
        $offences = Arr::get($item, 'offences');
        $offence_ids = [];

        foreach (explode(self::DELIM, $offences) as $offence) {
            $value = OffenceCase::getValueFromLabel($offence);
            $offence_ids[] = OffenceCase::where('name', $value)->first()->id;
        }

        return $offence_ids;
    }

    protected function createSources(array $item, $poachingObservation)
    {
        $sources = Arr::get($item, 'sources') ?: null;

        foreach (explode(self::DELIM, $sources) as $source) {
            $s = json_decode($source);
            $nsource = Source::create([
                'name' => $s->name,
                'description' => $s->description,
                'link' => $s->link,
                'poaching_observation_id' => $poachingObservation->id,
            ]);

            $nsource->save();
        }
    }

    protected function createSuspects(array $item, $poachingObservation)
    {
        $suspects = Arr::get($item, 'suspects') ?: null;

        foreach (explode(self::DELIM, $suspects) as $suspect) {
            $s = json_decode($suspect);
            $nsuspect = Suspect::create([
                'name' => $s->name,
                'place' => $s->place,
                'profile' => $s->profile,
                'phone' => $s->phone,
                'email' => $s->email,
                'social_media' => $s->social_media,
                'poaching_observation_id' => $poachingObservation->id,
            ]);

            $nsuspect->save();
        }
    }

    protected function getBoolean(array $item, string $key)
    {
        $value = Arr::get($item, $key, false);

        return $this->isTranslatedYes($value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    protected function getVerdict(array $item, string $key)
    {
        $value = Arr::get($item, $key, false);
        if ($this->isTranslatedRejected($value)) {
            return 'rejected';
        }

        if ($this->isTranslatedYes($value)) {
            return 'yes';
        }

        if ($this->isTranslatedNo($value)) {
            return 'no';
        }

        return;
    }

    protected function convertToNumberOrNull($arg)
    {
        if (is_numeric($arg)) {
            return $arg;
        }

        return;
    }

    protected function convertAccuracy(array $item)
    {
        $accuracy = Arr::get($item, 'accuracy') ?: null;

        if (! $accuracy) {
            return;
        }

        if (! is_numeric($accuracy)) {
            return 5000;
        }

        return $accuracy;
    }

    /**
     * Get observers full names.
     *
     * @param  array  $data
     * @return array $observer_ids
     */
    protected function getObservers(array $data): ?array
    {
        $observers = Arr::get($data, 'observers');
        $observer_ids = [];
        if (! $observers) {
            return null;
        }
        foreach (explode(self::DELIM, $observers) as $observer) {
            $obs = Observer::firstOrCreate([
                'name' => $observer,
            ]);
            $obs->save();
            $observer_ids[] = $obs->id;
        }

        return $observer_ids;
    }

    private function getCaseAgainst($item)
    {
        $lang = $this->model()->lang;
        if ($item === trans('labels.poaching_observations.individual', [], $lang)) {
            return 'individual';
        }
        if ($item === trans('labels.poaching_observations.legal_entity', [], $lang)) {
            return 'legal_entity';
        }

        return;
    }
}
