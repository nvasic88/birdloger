<?php

namespace App\Http\Requests;

use App\AtlasCode;
use App\Cites;
use App\License;
use App\Notifications\PoachingObservationForApproval;
use App\ObservationType;
use App\Observer;
use App\OffenceCase;
use App\PoachingObservation;
use App\Proceedings;
use App\Rules\Day;
use App\Rules\Decimal;
use App\Rules\Month;
use App\Sex;
use App\Source;
use App\Stage;
use App\Support\Dataset;
use App\Taxon;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StorePoachingObservation extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'taxon_id' => ['required', 'exists:taxa,id'],
            'taxon_suggestion' => ['required', 'string', 'max:191'],
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
            'stage_id' => ['nullable', Rule::in(Stage::pluck('id'))],
            'sex' => ['nullable', Rule::in(Sex::options()->keys())],
            'number' => ['nullable', 'integer', 'min:1'],
            'found_dead' => ['nullable', 'boolean'],
            'found_dead_note' => ['nullable', 'string', 'max:1000'],
            'data_license' => ['nullable', Rule::in(License::activeIds())],
            'photos' => [
                'nullable',
                'array',
                'max:' . config('biologer.photos_per_observation'),
            ],
            'photos.*.crop' => ['nullable', 'array'],
            'photos.*.crop.x' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.y' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.width' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.crop.height' => ['required_with:photos.*.crop', 'integer'],
            'photos.*.license' => ['nullable', Rule::in(License::activeIds())],
            'time_of_departure' => ['nullable', 'date_format:H:i'],
            'time_of_arrival' => ['nullable', 'date_format:H:i'],
            'project' => ['nullable', 'string', 'max:191'],
            'habitat' => ['nullable', 'string', 'max:191'],
            'found_on' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string'],
            'observation_types_ids' => [
                'nullable', 'array', Rule::in(ObservationType::pluck('id')),
            ],
            'observed_by_id' => ['nullable', Rule::exists('users', 'id')],
            'identified_by_id' => ['nullable', Rule::exists('users', 'id')],
            'dataset' => ['nullable', 'string', 'max:255'],
            'atlas_code' => ['nullable', 'integer', Rule::in(AtlasCode::CODES)],
            'number_of' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
            'data_provider' => ['nullable', 'string'],
            'data_limit' => ['nullable', 'string'],
            'field_observers' => ['nullable', 'array'],

            'indigenous' => ['boolean'],
            'exact_number' => ['boolean'],
            'place' => ['nullable', 'string'],
            'municipality' => ['nullable', 'string'],
            'data_id' => ['nullable', 'string'],
            'folder_id' => ['nullable', 'string'],
            'file' => ['nullable', 'string'],
            'offence_details' => ['nullable', 'string'],
            'in_report' => ['boolean'],
            'case_reported' => ['boolean'],
            'case_reported_by' => ['nullable', 'string'],
            'opportunity' => ['nullable', 'boolean'],
            'annotation' => ['nullable', 'string'],
            'suspect_name' => ['nullable', 'string'],
            'suspect_place' => ['nullable', 'string'],
            'suspect_profile' => ['nullable', 'string'],
            'suspect_note' => ['nullable', 'string'],
            'associates' => ['nullable', 'string'],
            'origin_of_individuals' => ['nullable', 'string'],
            'cites' => ['nullable', Rule::in(Cites::options()->keys())],
            'proceeding' => ['nullable', Rule::in(Proceedings::options()->keys())],
            'verdict' => ['nullable', Rule::in(['yes', 'no', 'rejected'])],
            'verdict_date' => ['nullable', 'date'],
            'dead_from_total' => ['nullable', 'integer'],
            'alive_from_total' => ['nullable', 'integer'],
            'sanction_rsd' => ['nullable', 'integer'],
            'sanction_eur' => ['nullable', 'integer'],
            'community_sentence' => ['nullable', 'integer'],
            'suspects_number' => ['nullable', 'integer'],
            'sources' => ['nullable', 'array'],

            'offences_ids' => ['nullable', 'array'],
            'offences_ids.*' => ['required', Rule::in(OffenceCase::pluck('id')->all())],
        ];
    }

    /**
     * Store observation and related data.
     *
     * @return \App\Observation
     */
    public function store()
    {
        return DB::transaction(function () {
            return tap($this->createObservation(), function ($poachingObservation) {
                $poachingObservation->addPhotos(
                    collect($this->input('photos', [])),
                    $this->user()->settings()->get('image_license')
                );

                $this->createObservers($poachingObservation);

                $this->createSources($poachingObservation);

                $this->syncRelations($poachingObservation);

                $this->logActivity($poachingObservation);

                // $this->notifyCurators($poachingObservation);
            });
        });
    }

    /**
     * Create observation.
     *
     * @return \App\PoachingObservation
     */
    protected function createObservation()
    {
        $electrocutionObservation = PoachingObservation::create($this->getSpecificObservationData());

        $electrocutionObservation->observation()->create($this->getGeneralObservationData());

        return $electrocutionObservation;
    }

    /**
     * Get observation data specific to field observation from the request.
     *
     * @return array
     */
    protected function getSpecificObservationData()
    {
        return [
            'license' => $this->input('data_license') ?: $this->user()->settings()->get('data_license'),
            'taxon_suggestion' => $this->getTaxonName(),
            'observed_by_id' => $this->getObservedBy(),
            'identified_by_id' => $this->getIdentifedBy(),

            'indigenous' => $this->input('indigenous'),
            'exact_number' => $this->input('exact_number'),
            'place' => $this->input('place'),
            'municipality' => $this->input('municipality'),
            'data_id' => $this->input('data_id'),
            'folder_id' => $this->input('folder_id'),
            'file' => $this->input('file'),
            'offence_details' => $this->input('offence_details'),
            'in_report' => $this->input('in_report'),
            'suspect_name' => $this->input('suspect_name'),
            'suspect_place' => $this->input('suspect_place'),
            'suspect_profile' => $this->input('suspect_profile'),
            'suspect_note' => $this->input('suspect_note'),
            'associates' => $this->input('associates'),
            'origin_of_individuals' => $this->input('origin_of_individuals'),
            'cites' => $this->input('cites'),
            'total' => $this->input('total'),
            'dead_from_total' => $this->input('dead_from_total'),
            'alive_from_total' => $this->input('alive_from_total'),
            'suspects_number' => $this->input('suspects_number'),

            'case_reported' => $this->input('case_reported'),
            'case_reported_by' => $this->input('case_reported', false) ? $this->input('case_reported_by') : null,
            'opportunity' => $this->input('case_reported', false) ? $this->input('opportunity') : null,
            'annotation' => $this->input('case_reported', false) ? $this->input('annotation') : null,
            'proceeding' => $this->input('case_reported', false) ? $this->input('proceeding') : null,
            'verdict' => $this->input('case_reported', false) ? $this->input('verdict') : null,
            'verdict_date' => $this->input('case_reported', false) ? $this->input('verdict_date') : null,
            'sanction_rsd' => $this->input('case_reported', false) ? $this->input('sanction_rsd') : null,
            'sanction_eur' => $this->input('case_reported', false) ? $this->input('sanction_eur') : null,
            'community_sentence' => $this->input('case_reported', false) ? $this->input('community_sentence') : null,
        ];
    }

    /**
     * Get general observation data from the request.
     *
     * @return array
     */
    protected function getGeneralObservationData()
    {
        $latitude = (float)str_replace(',', '.', $this->input('latitude'));
        $longitude = (float)str_replace(',', '.', $this->input('longitude'));

        return [
            'taxon_id' => $this->input('taxon_id'),
            'year' => $this->input('year'),
            'month' => $this->input('month') ? (int)$this->input('month') : null,
            'day' => $this->input('day') ? (int)$this->input('day') : null,
            'location' => $this->input('location'),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'mgrs10k' => mgrs10k($latitude, $longitude),
            'accuracy' => $this->input('accuracy'),
            'elevation' => $this->input('elevation'),
            'created_by_id' => $this->user()->id,
            'observer' => $this->getObserver(),
            'identifier' => $this->getIdentifier(),
            'sex' => $this->input('sex'),
            'stage_id' => $this->input('stage_id'),
            'number' => $this->input('number'),
            'number_of' => $this->input('number_of'),
            'note' => $this->input('note'),
            'project' => $this->input('project'),
            'habitat' => $this->input('habitat'),
            'found_on' => $this->input('found_on'),
            'description' => $this->input('description'),
            'original_identification' => $this->getTaxonName(),
            'dataset' => $this->input('dataset') ?? Dataset::default(),
            'client_name' => $this->getClientName(),
            'comment' => $this->input('comment'),
            'data_provider' => $this->input('data_provider'),
            'data_limit' => $this->input('data_limit'),
            'atlas_code' => $this->input('atlas_code'),
            'found_dead' => $this->input('found_dead', false),
            'found_dead_note' => $this->input('found_dead', false) ? $this->input('found_dead_note') : null,
        ];
    }

    /**
     * Get the taxon name.
     *
     * @return string|null
     */
    protected function getTaxonName()
    {
        return $this->input('taxon_id')
            ? Taxon::find($this->input('taxon_id'))->name
            : $this->input('taxon_suggestion');
    }

    /**
     * Get ID of observer name.
     *
     * @return string|null
     */
    protected function getObservedBy()
    {
        if (!$this->user()->hasAnyRole(['admin', 'curator'])) {
            return $this->user()->id;
        }

        if ($this->input('observed_by_id')) {
            return $this->input('observed_by_id');
        }

        if (!$this->input('observer')) {
            return $this->user()->id;
        }
    }

    /**
     * Get observer name.
     *
     * @return string|null
     */
    protected function getObserver()
    {
        if ($this->getObservedBy()) {
            return User::find($this->getObservedBy())->full_name;
        }

        return $this->input('observer');
    }

    /**
     * Get identifier name.
     *
     * @return string|null
     */
    protected function getIdentifier()
    {
        if (!$this->user()->hasAnyRole(['admin', 'curator'])) {
            return $this->isIdentified() ? $this->user()->full_name : null;
        }

        return $this->input('identified_by_id')
            ? User::find($this->input('identified_by_id'))->full_name
            : $this->input('identifier');
    }

    /**
     * Get ID of identifier.
     *
     * @return int|null
     */
    protected function getIdentifedBy()
    {
        if (!$this->isIdentified()) {
            return;
        }

        if (!$this->user()->hasAnyRole(['admin', 'curator', 'electrocution'])) {
            return $this->user()->id;
        }

        if ($this->input('identified_by_id')) {
            return $this->input('identified_by_id');
        }

        if (!$this->input('identifier')) {
            return $this->user()->id;
        }
    }

    /**
     * Check if the observation has been identified.
     *
     * @return bool
     */
    protected function isIdentified()
    {
        return $this->input('taxon_id') || $this->input('taxon_suggestion');
    }

    /**
     * Sync field observation relations.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return void
     */
    protected function syncRelations(PoachingObservation $poachingObservation)
    {
        $poachingObservation->observation->types()->sync($this->input('observation_types_ids', []));
        $poachingObservation->offences()->sync($this->input('offences_ids', []));
    }

    /**
     * Log created activity for field observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return void
     */
    protected function logActivity(PoachingObservation $poachingObservation)
    {
        activity()->performedOn($poachingObservation)
            ->causedBy($this->user())
            ->log('created');
    }

    /**
     * Notify curators of new field observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return void
     */
    private function notifyCurators(PoachingObservation $poachingObservation)
    {
        if ($poachingObservation->shouldBeCuratedBy($this->user(), false)) {
            return;
        }

        $poachingObservation->curators()->each(function ($curator) use ($poachingObservation) {
            if (!$this->user()->is($curator)) {
                $curator->notify(new PoachingObservationForApproval($poachingObservation));
            }
        });
    }

    private function getClientName()
    {
        $token = $this->user()->token();

        if (!$token) {
            return;
        }

        if ($token->transient()) {
            return sprintf('%s Website', config('app.name'));
        }

        return $token->client->name;
    }

    private function createObservers(PoachingObservation $poachingObservation)
    {
        $observer_ids = array();
        foreach ($this->input('field_observers') as $observer) {
            $obs = Observer::firstOrCreate([
                'firstName' => $observer['firstName'],
                'lastName' => $observer['lastName'],
            ]);
            $obs->save();
            $observer_ids[] = $obs->id;
        }
        $poachingObservation->observation->observers()->sync($observer_ids, []);
    }

    private function createSources($poachingObservation)
    {
        foreach ($this->input('sources') as $source) {
            $src = Source::firstOrCreate([
                'name' => $source['name'],
                'description' => $source['description'],
                'link' => $source['link'],
                'poaching_observation_id' => $poachingObservation['id'],
            ]);
            $src->save();
        }
    }
}
