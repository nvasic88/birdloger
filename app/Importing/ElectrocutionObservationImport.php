<?php

namespace App\Importing;

use App\DEM\Reader as DEMReader;
use App\ElectrocutionObservation;
use App\License;
use App\NumberOf;
use App\Observation;
use App\Observer;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\Month;
use App\Stage;
use App\Support\Dataset;
use App\Taxon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ElectrocutionObservationImport extends BaseImport
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
        return collect([
            [
                'label' => trans('labels.electrocution_observations.distance_from_pillar'),
                'value' => 'distance_from_pillar',
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
                'label' => trans('labels.electrocution_observations.annotation'),
                'value' => 'annotation',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.number_of_pillars'),
                'value' => 'number_of_pillars',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.transmission_line'),
                'value' => 'transmission_line',
                'required' => false,
            ],

            [
                'label' => trans('labels.electrocution_observations.time_of_departure'),
                'value' => 'time_of_departure',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.time_of_arrival'),
                'value' => 'time_of_arrival',
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
                'label' => trans('labels.field_observations.taxon'),
                'value' => 'taxon',
                'required' => true,
            ],
            [
                'label' => trans('labels.electrocution_observations.duration'),
                'value' => 'duration',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.distance'),
                'value' => 'distance',
                'required' => false,
            ],
            [
                'label' => trans('labels.electrocution_observations.transportation'),
                'value' => 'transportation',
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
            'distance_from_pillar' => ['nullable'],
            'age' => ['nullable'],
            'position' => ['string', 'nullable'],
            'state' => ['string', 'nullable'],
            'annotation' => ['text', 'nullable'],
            'number_of_pillars' => ['nullable'],
            'transmission_line' => ['string', 'nullable'],
            'time_of_departure' => ['date_format:H:i', 'nullable'],
            'time_of_arrival' => ['date_format:H:i:after:time_of_departure', 'nullable'],
            'duration' => ['nullable'],
            'distance' => ['nullable'],
            'transportation' => ['string', 'nullable'],

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
            'observers' => ['nullable', 'string'],
        ], [
            'distance_from_pillar' => trans('labels.electrocution_observations.distance_from_pillar'),
            'age' => trans('labels.electrocution_observations.age'),
            'position' => trans('labels.electrocution_observations.position'),
            'state' => trans('labels.electrocution_observations.state'),
            'annotation' => trans('labels.electrocution_observations.annotation'),
            'number_of_pillars' => trans('labels.electrocution_observations.number_of_pillars'),
            'transmission_line' => trans('labels.electrocution_observations.transmission_line'),
            'time_of_departure' => trans('labels.electrocution_observations.time_of_departure'),
            'time_of_arrival' => trans('labels.electrocution_observations.time_of_arrival'),
            'duration' => trans('labels.electrocution_observations.duration'),
            'distance' => trans('labels.electrocution_observations.distance'),
            'transportation' => trans('labels.electrocution_observations.transportation'),

            'latitude' => trans('labels.field_observations.latitude'),
            'longitude' => trans('labels.field_observations.longitude'),
            'accuracy' => trans('labels.field_observations.accuracy'),
            'day' => trans('labels.field_observations.day'),
            'month' => trans('labels.field_observations.month'),
            'year' => trans('labels.field_observations.year'),
            'date' => trans('labels.field_observations.date'),
            'input_date' => trans('labels.poaching_observations.input_date'),
            'taxon' => trans('labels.field_observations.taxon'),

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
     * Get observation data specific to field observation from the request.
     *
     * @param  array  $item
     * @return array
     */
    protected function getSpecificObservationData(array $item)
    {
        $distance = $this->convertToNumberOrNull(Arr::get($item, 'distance') ?: null);
        $duration = $this->convertToNumberOrNull(Arr::get($item, 'duration') ?: null);
        $number_of_pillars = $this->convertToNumberOrNull(Arr::get($item, 'number_of_pillars') ?: null);
        $distance_from_pillar = $this->convertToNumberOrNull(Arr::get($item, 'distance_from_pillar') ?: null);
        $age = $this->convertToNumberOrNull(Arr::get($item, 'age') ?: null);

        return [
            'license' => Arr::get($item, 'data_license') ?: $this->model()->user->settings()->get('data_license'),
            'taxon_suggestion' => Arr::get($item, 'taxon') ?: null,
            # 'observed_by_id' => $this->getObserverId($item),
            'identified_by_id' => $this->getIdentifierId($item),
            'license' => $this->getLicense($item),

            'distance_from_pillar' => $distance_from_pillar,
            'age' => $age,
            'position' => Arr::get($item, 'position') ?: null,
            'state' => $this->getBoolean($item, 'state'),
            'annotation' => Arr::get($item, 'annotation') ?: null,
            'number_of_pillars' => $number_of_pillars,
            'transmission_line' => $this->getBoolean($item, 'transmission_line'),
            'time_of_departure' => $this->getBoolean($item, 'time_of_departure'),
            'time_of_arrival' => $this->getBoolean($item, 'time_of_arrival'),
            'duration' => $duration,
            'distance' => $distance,
            'transportation' => Arr::get($item, 'transportation') ?: null,
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
