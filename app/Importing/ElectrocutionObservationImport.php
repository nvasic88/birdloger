<?php

namespace App\Importing;

use App\AtlasCode;
use App\DEM\Reader as DEMReader;
use App\ElectrocutionObservation;
use App\License;
use App\NumberOf;
use App\Observation;
use App\Observer;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\Month;
use App\Sex;
use App\Stage;
use App\Support\Dataset;
use App\Taxon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ElectrocutionObservationImport extends BaseImport
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
                'label' => trans('labels.electrocution_observations.death_cause'),
                'value' => 'death_cause',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.found_dead_note'),
                'value' => 'found_dead_note',
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
                'label' => trans('labels.electrocution_observations.column_type'),
                'value' => 'column_type',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.console_type'),
                'value' => 'console_type',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.voltage'),
                'value' => 'voltage',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.iba'),
                'value' => 'iba',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.number'),
                'value' => 'number',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.number_of'),
                'value' => 'number_of',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.data_provider'),
                'value' => 'data_provider',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.data_limit'),
                'value' => 'data_limit',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.note'),
                'value' => 'note',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.habitat'),
                'value' => 'habitat',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.time_of_corpse_found'),
                'value' => 'time_of_corpse_found',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.duration'),
                'value' => 'duration',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.distance_from_pillar'),
                'value' => 'distance_from_pillar',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.pillar_number'),
                'value' => 'pillar_number',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.age'),
                'value' => 'age',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.position'),
                'value' => 'position',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.state'),
                'value' => 'state',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.project'),
                'value' => 'project',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.dataset'),
                'value' => 'dataset',
                'required' => false,
            ],
            [
                'label' => trans('labels.exports.observers'),
                'value' => 'observers',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.data_license'),
                'value' => 'license',
                'required' => false,
            ],

        ])->pipe(function ($columns) use ($user) {
            if (! $user || optional($user)->hasAnyRole(['admin', 'electrocution'])) {
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
        return route('api.electrocution-observation-imports.errors', $this->model());
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
            'id' => ['nullable'],
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

            'distance_from_pillar' => ['nullable'],
            'age' => ['nullable'],
            'position' => ['string', 'nullable'],
            'state' => ['string', 'nullable'],
            'duration' => ['nullable'],

            'time_of_corpse_found' => ['nullable', 'date_format:H:i'],
            'death_cause' => ['nullable', Rule::in($this->deathCause())],
            'column_type' => ['nullable'],
            'console_type' => ['nullable'],
            'voltage' => ['nullable'],
            'iba' => ['nullable'],
            'pillar_number' => ['nullable'],
            'accuracy' => ['nullable'],
            'input_date' => ['nullable'],

            'observers' => ['nullable', 'string'],
            'license' => ['nullable', 'string', Rule::in(array_values(License::getOptions()))],
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
            'distance_from_pillar' => trans('labels.electrocution_observations.distance_from_pillar'),
            'age' => trans('labels.electrocution_observations.age'),
            'position' => trans('labels.electrocution_observations.position'),
            'state' => trans('labels.electrocution_observations.state'),

            'time_of_corpse_found' => trans('labels.electrocution_observations.time_of_corpse_found'),
            'duration' => trans('labels.electrocution_observations.duration'),
            'death_cause' => trans('labels.electrocution_observations.death_cause'),
            'column_type' => trans('labels.electrocution_observations.column_type'),
            'console_type' => trans('labels.electrocution_observations.console_type'),
            'voltage' => trans('labels.electrocution_observations.voltage'),
            'pillar_number' => trans('labels.electrocution_observations.pillar_number'),

            'latitude' => trans('labels.observations.latitude'),
            'longitude' => trans('labels.observations.longitude'),
            'accuracy' => trans('labels.observations.accuracy'),
            'day' => trans('labels.observations.day'),
            'month' => trans('labels.observations.month'),
            'year' => trans('labels.observations.year'),
            'date' => trans('labels.observations.date'),
            'input_date' => trans('labels.poaching_observations.input_date'),
            'taxon' => trans('labels.observations.taxon'),
            'license' => trans('labels.observations.data_license'),

            'observers' => trans('labels.observations.observers'),
        ]);
    }

    /**
     * Store data from single XLSX row.
     *
     * @param  array  $item
     * @return void
     */
    protected function storeSingleItem(array $item)
    {
        $electrocutionObservation = ElectrocutionObservation::create(
            $this->getSpecificObservationData($item)
        );

        $observation = $electrocutionObservation->observation()->save(
            new Observation($this->getGeneralObservationData($item))
        );

        $electrocutionObservation->observation->observers()->sync($this->getObservers($item), []);

        #TODO: Temporary available until majority of observations are imported..
        $electrocutionObservation->approve();

        activity()->performedOn($electrocutionObservation)
            ->causedBy($this->model()->user)
            ->log('created');

        if ($observation->isApproved()) {
            activity()->performedOn($electrocutionObservation)
                ->causedBy($this->model()->user)
                ->log('approved');
        }
    }

    /**
     * Get observation data specific to electrocution observation from the request.
     *
     * @param  array  $item
     * @return array
     */
    protected function getSpecificObservationData(array $item)
    {
        $distance_from_pillar = $this->convertToNumberOrNull(Arr::get($item, 'distance_from_pillar') ?: null);
        $age = $this->convertToNumberOrNull(Arr::get($item, 'age') ?: null);
        $death_cause = $this->getDeathCause(Arr::get($item, 'death_cause'));
        $position = $this->getPosition(Arr::get($item, 'position'));
        $state = $this->getState(Arr::get($item, 'state'));
        $duration = $this->convertToNumberOrNull(Arr::get($item, 'duration') ?: null);


        return [
            # 'license' => Arr::get($item, 'data_license') ?: $this->model()->user->settings()->get('data_license'),
            'taxon_suggestion' => Arr::get($item, 'taxon') ?: null,
            # 'observed_by_id' => $this->getObserverId($item),
            'identified_by_id' => $this->getIdentifierId($item),
            'license' => $this->getLicense($item),

            'distance_from_pillar' => $distance_from_pillar,
            'age' => $age,
            'position' => $position,
            'state' => $state,

            'time_of_corpse_found' => Arr::get($item, 'time_of_corpse_found') ?: null,

            'pillar_number' => Arr::get($item, 'pillar_number') ?: null,
            'column_type' => Arr::get($item, 'column_type') ?: null,
            'console_type' => Arr::get($item, 'console_type') ?: null,
            'voltage' => Arr::get($item, 'voltage') ?: null,
            'iba' => Arr::get($item, 'iba') ?: null,
            'death_cause' => $death_cause,
            'duration' => $duration,
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
        $number = $this->convertToNumberOrNull(Arr::get($item, 'number') ?: null);
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
            'number' => $number,
            'number_of' => NumberOf::getValueFromLabel(Arr::get($item, 'number_of', '')),
            'comment' => Arr::get($item, 'comment') ?: null,
            'data_provider' => Arr::get($item, 'data_provider') ?: null,
            'data_limit' => Arr::get($item, 'data_limit') ?: null,
            'habitat' => Arr::get($item, 'habitat') ?: null,
            'note' => Arr::get($item, 'note') ?: null,
            'description' => Arr::get($item, 'description') ?: null,
            'atlas_code' => $atlasCode === '' ? null : (int) $atlasCode,
            'found_dead_note' => Arr::get($item, 'found_dead_note') ?: null,
            'sex' => Sex::getValueFromLabel(Arr::get($item, 'sex', '')),
            'project' => Arr::get($item, 'project') ?: null,
        ];
    }

    /**
     * Get ID of taxon using its name.
     *
     * @param  array  $data
     * @return Taxon|void
     */
    protected function getTaxon(array $data)
    {
        $name = Arr::get($data, 'taxon');
        if ($name == null) {
            return;
        }

        return Taxon::findByName($name);
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
     * Get license for the observation.
     *
     * @param  array  $data
     * @return int|null
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

    protected function getBoolean(array $item, string $key)
    {
        $value = Arr::get($item, $key, false);

        return $this->isTranslatedYes($value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
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

    private function deathCause()
    {
        $lang = $this->model()->lang;

        return [
            trans('labels.electrocution_observations.electrocution', [], $lang),
            trans('labels.electrocution_observations.collision', [], $lang),
        ];
    }

    private function getDeathCause($item)
    {
        $lang = $this->model()->lang;
        if ($item === trans('labels.electrocution_observations.electrocution', [], $lang)) {
            return 'electrocution';
        }
        if ($item === trans('labels.electrocution_observations.collision', [], $lang)) {
            return 'collision';
        }
        return;
    }

    private function getPosition($item)
    {
        $lang = $this->model()->lang;
        if ($item === trans('labels.electrocution_observations.ground', [], $lang)) {
            return 'ground';
        }
        if ($item === trans('labels.electrocution_observations.pillar', [], $lang)) {
            return 'pillar';
        }
        return;
    }

    private function getState($item)
    {
        $lang = $this->model()->lang;
        if ($item === trans('labels.electrocution_observations.alive', [], $lang)) {
            return 'alive';
        }
        if ($item === trans('labels.electrocution_observations.fresh_corpse', [], $lang)) {
            return 'fresh_corpse';
        }
        if ($item === trans('labels.electrocution_observations.in_decay_state', [], $lang)) {
            return 'in_decay_state';
        }
        if ($item === trans('labels.electrocution_observations.corpse_remains', [], $lang)) {
            return 'corpse_remains';
        }
        if ($item === trans('labels.electrocution_observations.dry_remains', [], $lang)) {
            return 'dry_remains';
        }
        if ($item === trans('labels.electrocution_observations.fresh_remains', [], $lang)) {
            return 'fresh_remains';
        }

        return;
    }
}
