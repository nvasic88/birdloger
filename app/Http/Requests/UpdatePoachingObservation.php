<?php

namespace App\Http\Requests;

use App\ActivityLog\PoachingObservationDiff;
use App\AtlasCode;
use App\Cites;
use App\License;
use App\Notifications\PoachingObservationEdited;
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
use App\Suspect;
use App\Taxon;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdatePoachingObservation extends FormRequest
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
            'taxon_suggestion' => ['nullable', 'string', 'max:191'],
            'year' => ['bail', 'nullable', 'date_format:Y', 'before_or_equal:now'],
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
                'max:'.config('biologer.photos_per_observation'),
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

            'indigenous' => ['boolean'],
            'exact_number' => ['boolean'],
            'locality' => ['nullable', 'string'],
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
            'associates' => ['nullable', 'string'],
            'origin_of_individuals' => ['nullable', 'string'],
            'cites' => ['nullable', Rule::in(Cites::options()->keys())],
            'proceeding' => ['nullable', Rule::in(Proceedings::options()->keys())],
            'verdict' => ['nullable', Rule::in(['yes', 'no', 'rejected', 'declined', 'in_progress'])],
            'verdict_date' => ['nullable', 'date'],
            'total' => ['nullable', 'integer'],
            'dead_from_total' => ['nullable', 'integer'],
            'alive_from_total' => ['nullable', 'integer'],
            'sanction_rsd' => ['nullable', 'integer'],
            'sanction_eur' => ['nullable', 'integer'],
            'community_sentence' => ['nullable', 'integer'],
            'sources' => ['array'],
            'removed_sources' => ['array'],
            'suspects' => ['array'],
            'removed_suspects' => ['array'],
            'observers' => ['array'],

            'offences_ids' => ['nullable', 'array'],
            'offences_ids.*' => ['required', Rule::in(OffenceCase::pluck('id')->all())],

            'case_name' => ['nullable', 'string'],
            'case_against' => ['nullable', 'string'],
            'case_against_mb' => ['nullable', 'string'],
            'case_against_pib' => ['nullable', 'string'],
            'case_submitted_to' => ['nullable', 'string'],
        ];
    }

    /**
     * Store observation and related data.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return \App\PoachingObservation
     */
    public function save(PoachingObservation $poachingObservation)
    {
        return DB::transaction(function () use ($poachingObservation) {
            $oldPoachingObservation = $poachingObservation
                ->load('observation.types', 'observation.photos')
                ->replicate();

            $poachingObservation->update($this->getSpecificObservationData());
            $poachingObservation->load('observation')->observation->update($this->getGeneralObservationData());

            $poachingObservation->syncPhotos(
                collect($this->input('photos', [])),
                $this->user()->settings()->get('image_license')
            );

            $this->syncRelations($poachingObservation);

            $poachingObservation->observation->load('photos', 'types');

            $this->updateObservers($poachingObservation);
            $this->updateSources($poachingObservation);
            $this->updateSuspects($poachingObservation);

            $changed = PoachingObservationDiff::changes($poachingObservation, $oldPoachingObservation);

            // Log activity and move to pending only if something more than
            // updating photo license occurred.
            if (! empty($changed)) {
                $this->logActivity($poachingObservation, $changed);

                $poachingObservation->moveToPending();
            }

            $this->notifyCreator($poachingObservation);

            return $poachingObservation;
        });
    }

    /**
     * Get observation data specific to poaching observation from the request.
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

            'indigenous' => $this->input('indigenous'),
            'exact_number' => $this->input('exact_number'),
            'locality' => $this->input('locality'),
            'place' => $this->input('place'),
            'municipality' => $this->input('municipality'),
            'data_id' => $this->input('data_id'),
            'folder_id' => $this->input('folder_id'),
            'file' => $this->input('file'),
            'offence_details' => $this->input('offence_details'),
            'in_report' => $this->input('in_report'),
            'associates' => $this->input('associates'),
            'origin_of_individuals' => $this->input('origin_of_individuals'),
            'cites' => $this->input('cites'),
            'total' => $this->input('total'),
            'dead_from_total' => $this->input('dead_from_total'),
            'alive_from_total' => $this->input('alive_from_total'),
            'case_name' => $this->input('case_name'),
            'case_against' => $this->input('case_against'),
            'case_against_mb' => $this->input('case_against_mb'),
            'case_against_pib' => $this->input('case_against_pib'),
            'case_submitted_to' => $this->input('case_submitted_to'),

            'case_reported' => $this->input('case_reported'),
            'case_reported_by' => $this->input('case_reported_by'),
            'opportunity' => $this->input('opportunity'),
            'annotation' => $this->input('annotation'),
            'proceeding' => $this->input('proceeding'),
            'verdict' => $this->input('verdict'),
            'verdict_date' => $this->input('verdict_date'),
            'sanction_rsd' => $this->input('sanction_rsd'),
            'sanction_eur' => $this->input('sanction_eur'),
            'community_sentence' => $this->input('community_sentence'),
        ];

        if ($this->user()->hasAnyRole(['admin', 'curator'])) {
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
            'description' => $this->input('description'),
            'note' => $this->input('note'),
            'dataset' => $this->input('dataset') ?? Dataset::default(),
            'comment' => $this->input('comment'),
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
     * Log update activity for poaching observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @param array $beforeChange
     * @return void
     */
    protected function logActivity(PoachingObservation $poachingObservation, array $beforeChange)
    {
        activity()->performedOn($poachingObservation)
            ->causedBy($this->user())
            ->withProperty('old', $beforeChange)
            ->withProperty('reason', $this->input('reason'))
            ->log('updated');
    }

    /**
     * Sync poaching observation relations.
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
     * @param \App\PoachingObservation $poachingObservation
     * @return void
     */
    private function notifyCreator(PoachingObservation $poachingObservation)
    {
        // We don't want to send notification if the user is changing their own observation.
        if ($this->user()->is($poachingObservation->observation->creator)) {
            return;
        }

        $poachingObservation->observation->creator->notify(
            new PoachingObservationEdited($poachingObservation, $this->user())
        );
    }

    private function updateObservers(PoachingObservation $poachingObservation)
    {
        $observer_ids = [];

        foreach ($this->input('observers') as $observer) {
            if (isset($observer['id'])) {
                $observer_ids[] = $observer['id'];
                $obs = Observer::find($observer['id']);
                $obs->update([
                    'name' => $observer['name'],
                ]);
                $obs->save();

                continue;
            }
            $obs = Observer::firstOrCreate([
                'name' => $observer['name'],
            ]);
            $obs->save();
            $observer_ids[] = $obs->id;
        }

        if (empty($observer_ids)) {
            $poachingObservation->observation->observers()->detach();
        } else {
            $poachingObservation->observation->observers()->sync($observer_ids);
        }
    }

    private function updateSources(PoachingObservation $poachingObservation)
    {
        foreach ($this->input('removed_sources') as $removed) {
            Source::find($removed['id'])->delete();
        }
        foreach ($this->input('sources') as $source) {
            if (isset($source['id'])) {
                $s = Source::find($source['id']);
                $s->update([
                    'name' => $source['name'],
                    'description' => $source['description'],
                    'link' => $source['link'],
                    'ytid' => $source['ytid'],
                ]);

                continue;
            }
            $s = Source::create([
                'name' => $source['name'],
                'description' => $source['description'],
                'link' => $source['link'],
                'ytid' => $source['ytid'],
                'poaching_observation_id' => $poachingObservation->id,
            ]);
            $s->save();
        }
    }

    private function updateSuspects(PoachingObservation $poachingObservation)
    {
        foreach ($this->input('removed_suspects') as $removed) {
            Suspect::find($removed['id'])->delete();
        }
        foreach ($this->input('suspects') as $suspects) {
            if (isset($suspects['id'])) {
                $s = Suspect::find($suspects['id']);
                $s->update([
                    'name' => $suspects['name'],
                    'place' => $suspects['place'],
                    'profile' => $suspects['profile'],
                    'phone' => $suspects['phone'],
                    'email' => $suspects['email'],
                    'social_media' => $suspects['social_media'],
                    'note' => $suspects['note'],
                ]);
                $s->save();

                continue;
            }
            $s = Suspect::create([
                'name' => $suspects['name'],
                'place' => $suspects['place'],
                'profile' => $suspects['profile'],
                'phone' => $suspects['phone'],
                'email' => $suspects['email'],
                'social_media' => $suspects['social_media'],
                'note' => $suspects['note'],
                'poaching_observation_id' => $poachingObservation->id,
            ]);
            $s->save();
        }
    }
}
