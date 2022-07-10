<?php

namespace App\Importing;

use App\Cites;
use App\DEM\Reader as DEMReader;
use App\License;
use App\NumberOf;
use App\Observation;
use App\Observer;
use App\OffenceCase;
use App\PoachingObservation;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\InCaseInsensitive;
use App\Rules\Month;
use App\Source;
use App\Stage;
use App\Support\Dataset;
use App\Taxon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PoachingObservationImport extends BaseImport
{
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
                'required' => true,
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
                'label' => trans('labels.field_observations.latitude'),
                'value' => 'latitude',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.longitude'),
                'value' => 'longitude',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.accuracy'),
                'value' => 'accuracy',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.day'),
                'value' => 'day',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.month'),
                'value' => 'month',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.year'),
                'value' => 'year',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.date'),
                'value' => 'date',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.input_date'),
                'value' => 'input_date',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.taxon'),
                'value' => 'taxon',
                'required' => true,
            ],
            [
                'label' => trans('labels.poaching_observations.indigenous'),
                'value' => 'indigenous',
                'required' => true,
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
        ])->concat($offence_cases->map(function ($offence_case) {
            return [
                'label' => "{$offence_case}",
                'value' => "{$offence_case}",
                'required' => true,
            ];
        }))->concat([
            [
                'label' => trans('labels.poaching_observations.offences'),
                'value' => 'offences',
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
                'required' => true,
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
                'label' => trans('labels.poaching_observations.proceeding'),
                'value' => 'proceeding',
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
                'label' => trans('labels.poaching_observations.suspect_name'),
                'value' => 'suspect_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.suspect_place'),
                'value' => 'suspect_place',
                'required' => false,
            ],
            [
                'label' => trans('labels.poaching_observations.suspects_number'),
                'value' => 'suspects_number',
                'required' => false,
            ],
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
            'data_id' => ['string', 'nullable'],
            'folder_id' => ['numeric', 'nullable'],
            'file' => ['string', 'nullable'],
            'in_report' => ['string', 'required', new InCaseInsensitive($this->yesNo())],
            'locality' => ['nullable'],
            'place' => ['nullable'],
            'municipality' => ['nullable'],
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
            'accuracy' => ['nullable'],
            'date' => ['nullable'],
            'input_date' => ['nullable'],
            'taxon' => [
                'required',
                'string',
            ],
            'indigenous' => ['required', 'string', new InCaseInsensitive($this->yesNo())],
            'total' => ['nullable'],
            'dead_from_total' => ['nullable'],
            'alive_from_total' => ['nullable'],
            'exact_number' => ['nullable', 'string', new InCaseInsensitive($this->yesNo())],
            'offences' => ['nullable'],
            'offence_details' => ['nullable', 'string'],
            'case_reported' => ['string', 'required', new InCaseInsensitive($this->yesNo())],
            'case_reported_by' => ['nullable', 'string'],
            'verdict' => ['nullable', new InCaseInsensitive($this->yesNoRejected())],
            'verdict_date' => ['nullable'],
            'proceeding' => ['nullable', 'string'],
            'sanction_rsd' => ['nullable'],
            'sanction_eur' => ['nullable'],
            'community_sentence' => ['nullable'],
            'opportunity' => ['nullable', 'string', new InCaseInsensitive($this->yesNo())],
            'annotation' => ['nullable', 'string'],
            'suspect_name' => ['nullable', 'string'],
            'suspect_place' => ['nullable', 'string'],
            'suspect_number' => ['nullable', 'numeric'],
            'suspect_profile' => ['nullable', 'string'],
            'annotation1' => ['nullable', 'string'],
            'sources' => ['nullable', 'string'],
            'facebook' => ['nullable', 'string'],
            'youtube' => ['nullable', 'string'],
            'social_media' => ['nullable', 'string'],
            'ads' => ['nullable', 'string'],
            'institutions' => ['nullable', 'string'],
            'associates' => ['nullable', 'string'],
            'cites' => ['nullable', 'string', Rule::in(Cites::options())],
            'origin_of_individuals' => ['nullable', 'string'],
            'observers' => ['nullable', 'string'],
        ], [
            'data_id' => trans('labels.poaching_observations.data_id'),
            'folder_id' => trans('labels.poaching_observations.folder_id'),
            'file' => trans('labels.poaching_observations.file'),
            'in_report' => trans('labels.poaching_observations.in_report'),
            'locality' => trans('labels.poaching_observations.locality'),
            'municipality' => trans('labels.poaching_observations.municipality'),
            'place' => trans('labels.poaching_observations.place'),
            'latitude' => trans('labels.field_observations.latitude'),
            'longitude' => trans('labels.field_observations.longitude'),
            'accuracy' => trans('labels.field_observations.accuracy'),
            'day' => trans('labels.field_observations.day'),
            'month' => trans('labels.field_observations.month'),
            'year' => trans('labels.field_observations.year'),
            'date' => trans('labels.field_observations.date'),
            'input_date' => trans('labels.poaching_observations.input_date'),
            'taxon' => trans('labels.field_observations.taxon'),
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
            'annotation1' => trans('labels.poaching_observations.annotation'),
            'suspect_name' => trans('labels.poaching_observations.suspect_name'),
            'suspect_place' => trans('labels.poaching_observations.suspect_place'),
            'suspects_number' => trans('labels.poaching_observations.suspects_number'),
            'suspect_profile' => trans('labels.poaching_observations.suspect_profile'),
            'sources' => trans('labels.poaching_observations.sources'),
            'facebook' => trans('labels.poaching_observations.facebook'),
            'youtube' => trans('labels.poaching_observations.youtube'),
            'media' => trans('labels.poaching_observations.media'),
            'ads' => trans('labels.poaching_observations.ads'),
            'institutions' => trans('labels.poaching_observations.institutions'),
            'associates' => trans('labels.poaching_observations.associates'),
            'cites' => trans('labels.poaching_observations.cites'),
            'origin_of_individuals' => trans('labels.poaching_observations.origin_of_individuals'),
            'observers' => trans('labels.observations.observers'),
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

        $poachingObservation->approve();

        $this->createSources($item, $poachingObservation);

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
        $annotation = $this->mergeAnnotations($item);
        $total = $this->convertToNumberOrNull(Arr::get($item, 'total') ?: null);
        $dead_from_alive = $this->convertToNumberOrNull(Arr::get($item, 'dead_from_total') ?: null);
        $alive_from_total = $this->convertToNumberOrNull(Arr::get($item, 'alive_from_total') ?: null);
        $suspects_number = $this->convertToNumberOrNull(Arr::get($item, 'suspects_number') ?: null);

        return [
            'license' => Arr::get($item, 'data_license') ?: $this->model()->user->settings()->get('data_license'),
            'taxon_suggestion' => Arr::get($item, 'taxon') ?: null,
            # 'observed_by_id' => $this->getObserverId($item),
            'identified_by_id' => $this->getIdentifierId($item),
            'license' => $this->getLicense($item),

            'data_id' => Arr::get($item, 'data_id') ?: null,
            'folder_id' => Arr::get($item, 'folder_id') ?: null,
            'file' => Arr::get($item, 'file') ?: null,
            'in_report' => $this->getBoolean($item, 'in_report'),
            'locality' => Arr::get($item, 'locality') ?: null,
            'place' => Arr::get($item, 'place') ?: null,
            'municipality' => Arr::get($item, 'municipality') ?: null,
            'indigenous' => $this->getBoolean($item, 'indigenous'),
            'total' => $total,
            'dead_from_total' => $dead_from_alive,
            'alive_from_total' => $alive_from_total,
            'exact_number' => $this->getBoolean($item, 'exact_number'),
            'offence_details' => Arr::get($item, 'offence_details') ?: null,
            'case_reported' => $this->getBoolean($item, 'case_reported'),
            'case_reported_by' => Arr::get($item, 'case_reported_by') ?: null,
            'verdict' => $this->getVerdict($item, 'verdict'),
            'verdict_date' => Arr::get($item, 'verdict_date') ?: null,
            'sanction_rsd' => Arr::get($item, 'sanction_rsd') ?: null,
            'sanction_eur' => Arr::get($item, 'sanction_eur') ?: null,
            'community_sentence' => Arr::get($item, 'community_sentence') ?: null,
            'opportunity' => $this->getBoolean($item, 'opportunity'),
            'annotation' => $annotation,
            'suspect_name' => Arr::get($item, 'suspect_name') ?: null,
            'suspect_place' => Arr::get($item, 'suspect_place') ?: null,
            'suspects_number' => $suspects_number,
            'suspect_profile' => Arr::get($item, 'suspect_profile') ?: null,
            'cites' => Arr::get($item, 'cites') ?: null,
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
        $accuracy = $this->convertAccuracy($item);

        return [
            'taxon_id' => $taxon ? $taxon->id : null,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'day' => $day,
            'month' => $month,
            'year' => Arr::get($item, 'year') ?: null,
            'location' => Arr::get($item, 'location') ?: null,
            'accuracy' => $accuracy,
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
        return ($license = Arr::get($data, 'license'))
            ? License::findByName($license)->id
            : $this->model()->user->settings()->get('data_license');
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
        $offence_cases = collect(OffenceCase::labels())->toArray();
        $offence_ids = [];
        foreach ($offence_cases as $offence_case) {
            $case = Arr::get($item, $offence_case) ?: null;
            if (is_numeric($case)) {
                $value = OffenceCase::getValueFromLabel($offence_case);
                $offence_ids[] = OffenceCase::where('name', $value)->first()->id;
            }
        }

        return $offence_ids;
    }

    protected function createSources(array $item, $poachingObservation)
    {
        $source = Arr::get($item, 'sources') ?: null;

        $name = '';
        $link = '';
        $description = '';

        $facebook = Arr::get($item, 'facebook') ?: null;
        if ($facebook != null and trim($facebook) != '') {
            $name = 'social_media';
            if (Str::of((trim($facebook)))->startsWith('http')) {
                $link = trim($facebook);
            }
            $description = $source;
        }

        $youtube = Arr::get($item, 'youtube') ?: null;
        if ($youtube != null and trim($youtube) != '') {
            $name = 'social_media';
            if (Str::of((trim($youtube)))->startsWith('http')) {
                $link = trim($youtube);
            }
            $description = $source;
        }

        $media = Arr::get($item, 'media') ?: null;
        if ($media != null and trim($media) != '') {
            $name = 'media';
            if (Str::of((trim($media)))->startsWith('http')) {
                $link = trim($media);
            }
            $description = $source;
        }

        $ads = Arr::get($item, 'ads') ?: null;
        if ($ads != null and trim($ads) != '') {
            $name = 'ads';
            if (Str::of((trim($ads)))->startsWith('http')) {
                $link = trim($ads);
            }
            $description = $source;
        }

        $institutions = Arr::get($item, 'institutions') ?: null;
        if ($institutions != null and trim($institutions) != '') {
            $name = 'institutions';
            $description = $source;
            if (Str::of((trim($institutions)))->startsWith('http')) {
                $link = trim($institutions);
            } else {
                $description .= ' '.trim($institutions);
            }
        }

        $associates = Arr::get($item, 'associates') ?: null;
        if ($associates != null and trim($associates) != '') {
            $name = 'associates';
            $description = $source;
            if (Str::of((trim($associates)))->startsWith('http')) {
                $link = trim($associates);
            } else {
                $description .= ' '.trim($associates);
            }
        }

        if ($name == '') {
            return;
        }

        $source = Source::firstOrCreate([
            'name' => $name,
            'description' => $description,
            'link' => $link,
            'poaching_observation_id' => $poachingObservation->id,
        ]);

        $source->save();
    }

    protected function mergeAnnotations(array $item)
    {
        $a1 = Arr::get($item, 'annotation') ?: null;
        $a2 = Arr::get($item, 'annotation1') ?: null;

        if ($a1 == null and $a2 == null) {
            return;
        }

        if ($a1 == null) {
            return $a2;
        }

        if ($a2 == null) {
            return $a1;
        }

        return $a1.' '.$a2;
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
        foreach (explode('; ', $observers) as $observer) {
            $ob = explode(' ', $observer);
            if (count($ob) < 2 || count($ob) > 3) {
                break;
            }
            $firstName = $ob[0];
            $lastName = $ob[1];
            if (count($ob) > 2) {
                $lastName .= ' '.$ob[2];
            }
            $obs = Observer::firstOrCreate([
                'firstName' => $firstName,
                'lastName' => $lastName,
            ]);
            $obs->save();
            $observer_ids[] = $obs->id;
        }

        return $observer_ids;
    }
}
