<?php

namespace App\Http\Requests;

use App\ActivityLog\ElectrocutionObservationDiff;
use App\AtlasCode;
use App\ElectrocutionObservation;
use App\License;
use App\Notifications\ElectrocutionObservationEdited;
use App\ObservationType;
use App\Observer;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\Month;
use App\Sex;
use App\Stage;
use App\Support\Dataset;
use App\Taxon;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateElectrocutionObservation extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'taxon_id' => ['nullable', 'exists:taxa,id'],
            'taxon_suggestion' => ['nullable', 'string', 'max:255'],
            'year' => ['bail', 'required', 'date_format:Y', 'before_or_equal:now'],
            'month' => [
                'bail',
                'nullable',
                'numeric',
                new Month($this->input('year')),
            ],
            'day' => [
                'bail',
                'nullable',
                'numeric',
                new Day($this->input('year'), $this->input('month')),
            ],
            'latitude' => ['required', new Decimal(['min' => -90, 'max' => 90])],
            'longitude' => ['required', new Decimal(['min' => -180, 'max' => 180])],
            'elevation' => ['nullable', 'integer', 'max:10000'],
            'accuracy' => ['nullable', 'integer', 'max:10000'],
            'observer' => ['nullable', 'string'],
            'identifier' => ['nullable', 'string'],
            'sex' => ['nullable', Rule::in(Sex::options()->keys())],
            'stage_id' => ['nullable', Rule::in(Stage::pluck('id'))],
            'number' => ['nullable', 'integer', 'min:1'],
            'found_dead' => ['nullable', 'boolean'],
            'found_dead_note' => ['nullable'],
            'data_license' => ['nullable', Rule::in(License::activeIds())],
            'photos' => ['nullable', 'array', 'max:'.config('biologer.photos_per_observation')],
            'photos.*.id' => ['required_without:photos.*.path', 'integer'],
            'photos.*.path' => ['required_without:photos.*.id', 'string'],
            'photos.*.crop' => ['nullable', 'array'],
            'photos.*.crop.x' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.y' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.width' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.height' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.license' => ['nullable', Rule::in(License::activeIds())],
            'time_of_corpse_found' => ['nullable', 'date_format:H:i'],
            'project' => ['nullable', 'string', 'max:191'],
            'habitat' => ['nullable', 'string', 'max:191'],
            'found_on' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string'],
            'reason' => ['required', 'string', 'max:255'],
            'observation_types_ids' => [
                'nullable', 'array', Rule::in(ObservationType::pluck('id')),
            ],
            'observed_by_id' => ['nullable', Rule::exists('users', 'id')],
            'identified_by_id' => ['nullable', Rule::exists('users', 'id')],
            'dataset' => ['nullable', 'string', 'max:255'],
            'atlas_code' => ['nullable', 'integer', Rule::in(AtlasCode::CODES)],
            'number_of' => ['nullable', 'string'],
            'data_provider' => ['nullable', 'string'],
            'data_limit' => ['nullable', 'string'],
            'field_observers' => ['nullable', 'array'],
            'position' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'pillar_number' => ['nullable', 'string'],
            'distance_from_pillar' => ['nullable', 'integer'],
            'age' => ['nullable', 'integer', 'max:100'],
            'duration' => ['nullable', 'integer'],
            'death_cause' => ['nullable', 'string', Rule::in(['collision', 'electrocution'])],
            'column_type' => ['nullable','string'],
            'console_type' => ['nullable','string'],
            'voltage' => ['nullable','string'],
            'iba' => ['nullable','string'],
        ];
    }

    /**
     * Store observation and related data.
     *
     * @param ElectrocutionObservation $electrocutionObservation
     * @return ElectrocutionObservation
     */
    public function save(ElectrocutionObservation $electrocutionObservation)
    {
        return DB::transaction(function () use ($electrocutionObservation) {
            $oldElectrocutionObservation = $electrocutionObservation->load('observation.types', 'observation.photos')->replicate();

            $electrocutionObservation->update($this->getSpecificObservationData());
            $electrocutionObservation->load('observation')->observation->update($this->getGeneralObservationData());

            $electrocutionObservation->syncPhotos(
                collect($this->input('photos', [])),
                $this->user()->settings()->get('image_license')
            );

            $this->syncRelations($electrocutionObservation);

            $electrocutionObservation->observation->load('photos', 'types');

            $this->updateObservers($electrocutionObservation);

            $changed = ElectrocutionObservationDiff::changes($electrocutionObservation, $oldElectrocutionObservation);

            // Log activity and move to pending only if something more than
            // updating photo license occurred.
            if (! empty($changed)) {
                $this->logActivity($electrocutionObservation, $changed);

                # $electrocutionObservation->moveToPending();
            }

            $this->notifyCreator($electrocutionObservation);

            return $electrocutionObservation;
        });
    }

    /**
     * Get observation data specific to electrocution observation from the request.
     *
     * @return array
     */
    protected function getSpecificObservationData()
    {
        $data = [
            'license' => $this->input('data_license') ?: $this->user()->settings()->get('data_license'),
            'taxon_suggestion' => $this->input('taxon_id')
                ? Taxon::find($this->input('taxon_id'))->name
                : $this->input('taxon_suggestion'),
            'time_of_corpse_found' => $this->input('time_of_corpse_found'),
            'position' => $this->input('position'),
            'state' => $this->input('state'),
            'pillar_number' => $this->input('pillar_number'),
            'distance_from_pillar' => $this->input('distance_from_pillar'),
            'age' => $this->input('age'),
            'duration' => $this->input('duration'),
            'death_cause' => $this->input('death_cause'),
            'column_type' => $this->input('column_type'),
            'console_type' => $this->input('console_type'),
            'voltage' => $this->input('voltage'),
            'iba' => $this->input('iba'),
        ];

        if ($this->user()->hasAnyRole(['admin', 'curator', 'electrocution'])) {
            $data['observed_by_id'] = $this->input('observed_by_id');
            $data['identified_by_id'] = $this->input('identified_by_id');
        }

        return $data;
    }

    /**
     * Get general observation data from the request.
     *
     * @return array
     */
    protected function getGeneralObservationData()
    {
        $latitude = (float) str_replace(',', '.', $this->input('latitude'));
        $longitude = (float) str_replace(',', '.', $this->input('longitude'));

        $data = [
            'taxon_id' => $this->input('taxon_id'),
            'year' => $this->input('year'),
            'month' => $this->input('month') ? (int) $this->input('month') : null,
            'day' => $this->input('day') ? (int) $this->input('day') : null,
            'location' => $this->input('location'),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'mgrs10k' => mgrs10k($latitude, $longitude),
            'accuracy' => $this->input('accuracy'),
            'elevation' => $this->input('elevation'),
            'sex' => $this->input('sex'),
            'number' => $this->input('number'),
            'number_of' => $this->input('number_of'),
            'stage_id' => $this->input('stage_id'),
            'project' => $this->input('project'),
            'habitat' => $this->input('habitat'),
            'found_on' => $this->input('found_on'),
            'note' => $this->input('note'),
            'dataset' => $this->input('dataset') ?? Dataset::default(),
            'data_provider' => $this->input('data_provider'),
            'data_limit' => $this->input('data_limit'),
            'atlas_code' => $this->input('atlas_code'),
            'found_dead' => $this->input('found_dead', false),
            'found_dead_note' => $this->input('found_dead', false) ? $this->input('found_dead_note') : null,
        ];

        if ($this->user()->hasAnyRole(['admin', 'curator'])) {
            $data['observer'] = $this->getObserver();
            $data['identifier'] = $this->getIdentifier();
        }

        return $data;
    }

    /**
     * Log update activity for electrocution observation.
     *
     * @param ElectrocutionObservation $electrocutionObservation
     * @param array $beforeChange
     * @return void
     */
    protected function logActivity(ElectrocutionObservation $electrocutionObservation, array $beforeChange)
    {
        activity()->performedOn($electrocutionObservation)
            ->causedBy($this->user())
            ->withProperty('old', $beforeChange)
            ->withProperty('reason', $this->input('reason'))
            ->log('updated');
    }

    /**
     * Sync electrocution observation relations.
     *
     * @param ElectrocutionObservation $electrocutionObservation
     * @return void
     */
    protected function syncRelations(ElectrocutionObservation $electrocutionObservation)
    {
        $electrocutionObservation->observation->types()->sync($this->input('observation_types_ids', []));
    }

    /**
     * Get observer name.
     *
     * @return string|null
     */
    protected function getObserver()
    {
        if (! $this->input('observed_by_id')) {
            return $this->input('observer');
        }

        return optional(User::find($this->input('observed_by_id')))->full_name ?? $this->input('observer');
    }

    /**
     * Get identifier name.
     *
     * @return string|null
     */
    protected function getIdentifier()
    {
        if (! $this->input('identified_by_id')) {
            return $this->input('identifier');
        }

        return optional(User::find($this->input('identified_by_id')))->full_name
            ?? $this->input('identifier');
    }

    /**
     * Send notification to creator of observation that it has been updated.
     *
     * @param ElectrocutionObservation $electrocutionObservation
     * @return void
     */
    private function notifyCreator(ElectrocutionObservation $electrocutionObservation)
    {
        // We don't want to send notification if the user is changing their own observation.
        if ($this->user()->is($electrocutionObservation->observation->creator)) {
            return;
        }

        $electrocutionObservation->observation->creator->notify(
            new ElectrocutionObservationEdited($electrocutionObservation, $this->user())
        );
    }

    private function updateObservers(ElectrocutionObservation $electrocutionObservation)
    {
        $observer_ids = [];

        foreach ($this->input('observers') as $observer) {
            $observer_ids[] = $observer['id'];
        }

        foreach ($this->input('field_observers') as $observer) {
            $obs = Observer::firstOrCreate([
                'firstName' => $observer['firstName'],
                'lastName' => $observer['lastName'],
            ]);
            $obs->save();
            $observer_ids[] = $obs->id;
        }

        if (empty($observer_ids)) {
            $electrocutionObservation->observation->observers()->detach();
        } else {
            $electrocutionObservation->observation->observers()->sync($observer_ids);
        }
    }
}
