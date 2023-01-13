<?php

namespace App\Importing;

use App\AtlasCode;
use App\DEM\Reader as DEMReader;
use App\FieldObservation;
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

class FieldObservationImport extends BaseImport
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
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.rid'),
                'value' => 'rid',
                'required' => false,
            ],
            [
                'label' => trans('labels.field_observations.fid'),
                'value' => 'fid',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.latitude'),
                'value' => 'latitude',
                'required' => true,
            ],
            [
                'label' => trans('labels.observations.longitude'),
                'value' => 'longitude',
                'required' => true,
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
                'required' => true,
            ],
            [
                'label' => trans('labels.observations.time'),
                'value' => 'time',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.taxon'),
                'value' => 'taxon',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
                'required' => true,
            ],
            [
                'label' => trans('labels.observations.atlas_code'),
                'value' => 'atlas_code',
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
                'label' => trans('labels.observations.comment'),
                'value' => 'comment',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.identifier'),
                'value' => 'identifier',
                'required' => false,
            ],
            [
                'label' => trans('labels.exports.observers'),
                'value' => 'observers',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.location'),
                'value' => 'location',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.mgrs10k'),
                'value' => 'mgrs10k',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.accuracy'),
                'value' => 'accuracy',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.elevation'),
                'value' => 'elevation',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.sex'),
                'value' => 'sex',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.stage'),
                'value' => 'stage',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.data_license'),
                'value' => 'license',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.note'),
                'value' => 'note',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.description'),
                'value' => 'description',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.project'),
                'value' => 'project',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.habitat'),
                'value' => 'habitat',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.found_dead'),
                'value' => 'found_dead',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.found_dead_note'),
                'value' => 'found_dead_note',
                'required' => false,
            ],
            [
                'label' => trans('labels.observations.dataset'),
                'value' => 'dataset',
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
        return route('api.field-observation-imports.errors', $this->model());
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
            'taxon' => [
                'nullable',
                'string',
            ],
            'spid' => [
                'required',
                Rule::exists('taxa', 'spid'),
            ],
            'year' => ['bail', 'date_format:Y', 'required', 'before_or_equal:now'],
            'month' => [
                'bail',
                'nullable',
                'numeric',
                new Month(Arr::get($data, 'year')),
            ],
            'day' => [
                'bail',
                'nullable',
                'numeric',
                new Day(Arr::get($data, 'year'), Arr::get($data, 'month')),
            ],
            'latitude' => ['required', new Decimal(['min' => -90, 'max' => 90])],
            'longitude' => ['required', new Decimal(['min' => -180, 'max' => 180])],
            'location' => ['nullable'],
            'elevation' => ['nullable', 'integer', 'max:10000'],
            'accuracy' => ['nullable', 'integer', 'max:50000'],
            'observers' => ['nullable', 'string'],
            'identifier' => ['nullable', 'string'],
            'sex' => ['nullable', Rule::in(Sex::options())],
            'stage' => ['nullable', Rule::in($this->stagesTranslatedNames())],
            'number' => ['nullable', 'integer', 'min:1'],
            'number_of' => ['nullable', 'string',
                Rule::in(NumberOf::options()), ],
            'found_dead' => ['nullable', 'string', Rule::in($this->yesNo())],
            'found_dead_note' => ['nullable', 'string', 'max:1000'],
            'time' => ['nullable', 'date_format:H:i'],
            'project' => ['nullable', 'string', 'max:191'],
            'habitat' => ['nullable', 'string', 'max:191'],
            'found_on' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'original_identification' => ['nullable', 'string'],
            'dataset' => ['nullable', 'string'],
            'rid' => ['nullable', 'integer', 'min:1'],
            'fid' => ['nullable', 'string'],
            'data_provider' => ['nullable', 'string'],
            'data_limit' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
            'atlas_code' => ['nullable', 'integer', Rule::in(AtlasCode::CODES)],
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
            'rid' => trans('labels.observations.rid'),
            'fid' => trans('labels.observations.fid'),
            'latitude' => trans('labels.observations.latitude'),
            'longitude' => trans('labels.observations.longitude'),
            'day' => trans('labels.observations.day'),
            'month' => trans('labels.observations.month'),
            'year' => trans('labels.observations.year'),
            'time' => trans('labels.observations.time'),
            'taxon' => trans('labels.observations.taxon'),
            'spid' => trans('labels.taxa.spid'),
            'atlas_code' => trans('labels.observations.atlas_code'),
            'number' => trans('labels.observations.number'),
            'number_of' => trans('labels.observations.number_of'),
            'data_provider' => trans('labels.observations.data_provider'),
            'data_limit' => trans('labels.observations.data_limit'),
            'comment' => trans('labels.observations.comment'),
            'identifier' => trans('labels.observations.identifier'),
            'observers' => trans('labels.observations.observers'),
            'location' => trans('labels.observations.location'),
            'accuracy' => trans('labels.observations.accuracy'),
            'elevation' => trans('labels.observations.elevation'),
            'sex' => trans('labels.observations.sex'),
            'stage' => trans('labels.observations.stage'),
            'license' => trans('labels.observations.data_license'),
            'note' => trans('labels.observations.note'),
            'project' => trans('labels.observations.project'),
            'habitat' => trans('labels.observations.habitat'),
            'found_on' => trans('labels.observations.found_on'),
            'found_dead' => trans('labels.observations.found_dead'),
            'found_dead_note' => trans('labels.observations.found_dead_note'),
            # 'status' => trans('labels.observations.status'),
            # 'types' => trans('labels.observations.types'),
            'original_identification' => trans('labels.observations.original_identification'),
            'dataset' => trans('labels.observations.dataset'),
            'description' => trans('labels.observations.description'),
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
     * Store data from single XLSX row.
     *
     * @param  array  $item
     * @return void
     */
    protected function storeSingleItem(array $item)
    {
        $fieldObservation = FieldObservation::create(
            $this->getSpecificObservationData($item)
        );

        $observation = $fieldObservation->observation()->save(
            new Observation($this->getGeneralObservationData($item))
        );

        $fieldObservation->observation->observers()->sync($this->getObservers($item), []);

        #TODO: Temporary available until majority of observations are imported..
        $fieldObservation->approve();

        activity()->performedOn($fieldObservation)
            ->causedBy($this->model()->user)
            ->log('created');

        if ($observation->isApproved()) {
            activity()->performedOn($fieldObservation)
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
        return [
            # 'license' => Arr::get($item, 'data_license') ?: $this->model()->user->settings()->get('data_license'),
            'taxon_suggestion' => Arr::get($item, 'taxon') ?: null,
            'time' => Arr::get($item, 'time') ?: null,
            # 'observed_by_id' => $this->getObserverId($item),
            'identified_by_id' => $this->getIdentifierId($item),
            'license' => $this->getLicense($item),
            'rid' => Arr::get($item, 'rid') ?: null,
            'fid' => Arr::get($item, 'fid') ?: null,
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
        $taxon = $this->getTaxonBySPID($item);
        $atlasCode = Arr::get($item, 'atlas_code');

        return [
            'taxon_id' => $taxon ? $taxon->id : null,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'day' => Arr::get($item, 'day') ?: null,
            'month' => Arr::get($item, 'month') ?: null,
            'year' => Arr::get($item, 'year'),
            'location' => Arr::get($item, 'location') ?: null,
            'mgrs10k' => mgrs10k($latitude, $longitude),
            'accuracy' => Arr::get($item, 'accuracy') ?: null,
            'elevation' => $this->getElevation($item),
            'created_by_id' => $this->model()->for_user_id ?: $this->model()->user_id,
            # 'observer' => $this->getObserver($item),
            'identifier' => $this->getIdentifier($item),
            'sex' => Sex::getValueFromLabel(Arr::get($item, 'sex', '')),
            'number' => Arr::get($item, 'number') ?: null,
            'note' => Arr::get($item, 'note') ?: null,
            'project' => Arr::get($item, 'project') ?: null,
            'habitat' => Arr::get($item, 'habitat') ?: null,
            'found_on' => Arr::get($item, 'found_on') ?: null,
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
        return Taxon::findByName(Arr::get($data, 'taxon'));
    }

    /**
     * Get ID of taxon using it's name.
     *
     * @param  array  $data
     * @return Taxon|null
     */
    protected function getTaxonBySPID(array $data)
    {
        return Taxon::findBySPID(Arr::get($data, 'spid'));
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
}
