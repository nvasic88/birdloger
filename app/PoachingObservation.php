<?php

namespace App;

use App\Concerns\CanMemoize;
use App\Concerns\MappedSorting;
use App\Contracts\FlatArrayable;
use App\Filters\Filterable;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;

class PoachingObservation extends Model implements FlatArrayable
{
    use CanMemoize, Filterable, MappedSorting;

    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_UNIDENTIFIABLE = 'unidentifiable';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'unidentifiable' => false,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'license' => 'integer',
        'unidentifiable' => 'boolean',
        'approved_at' => 'datetime',
        'indigenous' => 'boolean',
        'exact_number' => 'boolean',
        'in_report' => 'boolean',
        'case_reported' => 'boolean',
        'opportunity' => 'boolean',
        'total' => 'integer',
        'dead_from_total' => 'integer',
        'alive_from_total' => 'integer',
        'sanction_rsd' => 'integer',
        'sanction_eur' => 'integer',
        'community_sentence' => 'integer',
        'verdict_date' => 'datetime',
    ];

    protected function filters()
    {
        return [
            'id' => \App\Filters\Ids::class,
            'taxon' => \App\Filters\FieldObservation\Taxon::class,
            'taxonId' => \App\Filters\NullFilter::class,
            'includeChildTaxa' => \App\Filters\NullFilter::class,
            'year' => \App\Filters\FieldObservation\ObservationAttribute::class,
            'month' => \App\Filters\FieldObservation\ObservationAttribute::class,
            'day' => \App\Filters\FieldObservation\ObservationAttribute::class,
            'status' => \App\Filters\FieldObservation\Status::class,
            'photos' => \App\Filters\FieldObservation\Photos::class,
            'observer' => \App\Filters\FieldObservation\ObservationAttributeLike::class,
            'sort_by' => \App\Filters\SortBy::class,
            'project' => \App\Filters\FieldObservation\ObservationAttributeLike::class,
        ];
    }

    protected function sortMap()
    {
        return [
            'day' => 'observation.day',
            'month' => 'observation.month',
            'year' => 'observation.year',
            'latitude' => 'observation.latitude',
            'longitude' => 'observation.longitude',
            'mgrs10k' => 'observation.mgrs10k',
            'observer' => 'observation.observer',
            'taxon_name' => 'observation.taxon.name',
        ];
    }

    /**
     * List of fields that poaching observations can be sorted by.
     *
     * @return array
     */
    public static function sortableFields()
    {
        return [
            'id', 'taxon_name', 'year', 'month', 'day', 'observer',
        ];
    }

    /**
     * Main observation data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function observation()
    {
        return $this->morphOne(Observation::class, 'details');
    }

    /**
     * Photos of the observation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function photos()
    {
        return $this->observation->photos();
    }

    /**
     * Stage of the observation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    /**
     * Can have many offence cases.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function offences()
    {
        return $this->belongsToMany(
            OffenceCase::class,
            'offence_case_poaching_observation',
            'poaching_id',
            'offence_id'
        );
    }

    /**
     * Sources of the poaching.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    /**
     * Suspects of the poaching.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suspects()
    {
        return $this->hasMany(Suspect::class);
    }

    /**
     * Types of the observation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types()
    {
        return $this->observation->types();
    }

    /**
     * Activity recorded on the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest()->latest('id');
    }

    /**
     * User that made the observation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function observedBy()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * User that has identified poaching observation taxon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identifiedBy()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope the query to get identifiable observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIdentifiable($query)
    {
        return $query->where('unidentifiable', false);
    }

    /**
     * Scope the query to get unidentifiable observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnidentifiable($query)
    {
        return $query->where('unidentifiable', true);
    }

    /**
     * Get observations created by given user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy($query, User $user)
    {
        return $query->whereHas('observation', function ($q) use ($user) {
            return $q->createdBy($user);
        });
    }

    /**
     * Get approved observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->whereHas('observation', function ($q) {
            return $q->approved();
        });
    }

    /**
     * Get unapproved observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnapproved($query)
    {
        return $query->whereHas('observation', function ($q) {
            return $q->unapproved();
        });
    }

    /**
     * Get unapproved observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->identifiable()->unapproved();
    }

    /**
     * Get only approvable observations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApprovable($query)
    {
        return $query->whereHas('observation', function ($query) {
            return $query->unapproved()->whereHas('taxon', function ($query) {
                return $query->speciesOrLower();
            });
        });
    }

    /**
     * Get only observations of taxa curated by given user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCuratedBy($query, User $user)
    {
        return $query->whereHas('observation', function ($observation) use ($user) {
            return $observation->taxonCuratedBy($user);
        });
    }

    /**
     * Get only observations of taxa curated by given user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        License::applyConstraintsToFieldObservations($query);
    }

    /**
     * Getter for time attribute.
     * @param string $value
     * @return \Illuminate\Support\Carbon|null
     */
    public function getTimeAttribute($value)
    {
        return $this->memoize('time', function () use ($value) {
            return $value ? Carbon::parse($value) : null;
        });
    }

    /**
     * Setter for time attribute.
     *
     * @param string $value
     */
    public function setTimeAttribute($value)
    {
        $this->forgetMemoized('time')->attributes['time'] = $value;
    }

    /**
     * Get observation observer name.
     *
     * @return string
     */
    public function getObserverAttribute()
    {
        return optional($this->observedBy)->full_name ?: $this->observation->observer;
    }

    /**
     * Get observation identifier name.
     *
     * @return string
     */
    public function getIdentifierAttribute()
    {
        return optional($this->identifiedBy)->full_name ?: $this->observation->identifier;
    }

    /**
     * Rank translation.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->unidentifiable) {
            return static::STATUS_UNIDENTIFIABLE;
        }

        if ($this->isApproved()) {
            return static::STATUS_APPROVED;
        }

        return static::STATUS_PENDING;
    }

    /**
     * Get translated status.
     *
     * @return string
     */
    public function getStatusTranslationAttribute()
    {
        return trans('labels.observations.statuses.'.$this->status);
    }

    /**
     * Get translated license name.
     *
     * @return string
     */
    public function getLicenseTranslationAttribute()
    {
        return trans('licenses.'.$this->license);
    }

    /**
     * Add photos to the observation, using photos' paths.
     *
     * @param array $photos Paths
     * @param int $defaultLicense
     * @return array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function addPhotos($photos, $defaultLicense)
    {
        return $this->photos()->saveMany(
            collect($photos)->filter(function ($photo) {
                return UploadedPhoto::exists($photo['path']);
            })->map(function ($photo) use ($defaultLicense) {
                return Photo::store(UploadedPhoto::relativePath($photo['path']), [
                    'author' => $this->observation->observer,
                    'license' => empty($photo['license']) ? $defaultLicense : $photo['license'],
                ], Arr::get($photo, 'crop', []));
            })
        );
    }

    /**
     * Remove unused photos and add new ones.
     *
     * @param Collection $photos
     * @param int $defaultLicense
     * @return array|array[]
     */
    public function syncPhotos($photos, $defaultLicense)
    {
        $result = [
            'cropped' => [],
            'added' => [],
            'removed' => [],
        ];

        $current = $this->photos()->get();


        // Removing
        $current->whereNotIn('id', $photos->pluck('id'))->each(function ($photo) use (&$result) {
            $result['removed'][] = $photo;
            $photo->delete();
        });

        // Cropping old
        $old = $current->pluck('id')->intersect($photos->pluck('id'));

        $current->whereIn('id', $old)->each(function ($photo) use ($photos, &$result, $defaultLicense) {
            $updatedPhoto = $photos->where('id', $photo->id)->first();

            if (array_key_exists('license', $updatedPhoto) && $updatedPhoto['license'] != $photo->license) {
                $photo->update(['license' => $updatedPhoto['license'] ?? $defaultLicense]);
            }

            $crop = Arr::get($updatedPhoto, 'crop');

            if ($crop) {
                $photo->crop($crop['width'], $crop['height'], $crop['x'], $crop['y']);
                $result['cropped'][] = $photo;
            }
        });

        // Adding new
        $new = $photos->filter(function ($photo) {
            return empty(Arr::get($photo, 'id'));
        });

        $result['added'] = $this->addPhotos($new, $defaultLicense)->all();

        return $result;
    }

    /**
     * Approve poaching observation.
     *
     * @return $this
     */
    public function approve()
    {
        $this->observation->approve();

        if ($this->unidentifiable) {
            $this->forceFill(['unidentifiable' => false])->save();
        }

        return $this;
    }

    /**
     * Mark observation as unidentifiable.
     *
     * @return $this
     */
    public function markAsUnidentifiable()
    {
        $this->observation->unapprove();

        if (! $this->unidentifiable) {
            $this->forceFill(['unidentifiable' => true])->save();
        }

        return $this;
    }

    /**
     * Move observation to pending.
     *
     * @return $this
     */
    public function moveToPending()
    {
        $this->observation->unapprove();

        if ($this->unidentifiable) {
            $this->forceFill(['unidentifiable' => false])->save();
        }

        return $this;
    }

    /**
     * Check if poaching observation is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return optional($this->observation)->isApproved();
    }

    /**
     * Check if poaching observation is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return ! $this->isApproved() && ! $this->unidentifiable;
    }

    /**
     * Check if observation is created by given user.
     *
     * @param User $user
     * @return bool
     */
    public function isCreatedBy(User $user)
    {
        return $this->observation->isCreatedBy($user);
    }

    /**
     * Check if given user should curate this observation.
     *
     * @param User $user
     * @param bool $evenWithoutTaxa
     * @return bool
     */
    public function shouldBeCuratedBy(User $user, bool $evenWithoutTaxa = true)
    {
        return $this->observation->shouldBeCuratedBy($user, $evenWithoutTaxa);
    }

    /**
     * Check if the observation can be seen by others.
     *
     * @return bool
     */
    public function isAtLeastPartiallyOpenData()
    {
        return $this->license < 40;
    }

    /**
     * Get observer's name.
     *
     * @return string
     */
    public function creatorName()
    {
        return $this->observation->creator->full_name;
    }

    /**
     * Get curators for the observation.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function curators()
    {
        $taxon = $this->observation->taxon;

        if (empty($taxon)) {
            return User::whereHas('roles', function ($query) {
                $query->whereName('curator');
            });
        }

        $curators = $taxon->load('ancestors.curators')
            ->ancestors
            ->pluck('curators')
            ->push($taxon->curators)
            ->flatten();

        return \Illuminate\Database\Eloquent\Collection::make($curators)->unique();
    }

    /**
     * Get data license instance.
     *
     * @return \App\License|null
     */
    public function license()
    {
        return License::findById($this->license);
    }

    /**
     * Check if real coordinates should be hidden.
     *
     * @return bool
     */
    public function shouldHideRealCoordinates()
    {
        return $this->license()->shouldHideRealCoordinates() ||
            optional($this->observation->taxon)->restricted;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'taxon' => $this->observation->taxon,
            'taxon_id' => $this->observation->taxon_id,
            'taxon_suggestion' => $this->taxon_suggestion,
            'day' => $this->observation->day,
            'month' => $this->observation->month,
            'year' => $this->observation->year,
            'location' => $this->observation->location,
            'latitude' => $this->observation->latitude,
            'longitude' => $this->observation->longitude,
            'mgrs10k' => $this->observation->mgrs10k,
            'accuracy' => $this->observation->accuracy,
            'elevation' => $this->observation->elevation,
            'photos' => $this->observation->photos,
            'observer' => $this->observer,
            'identifier' => $this->identifier,
            'license' => $this->license,
            'sex' => $this->observation->sex,
            'stage_id' => $this->observation->stage_id,
            'number' => $this->observation->number,
            'number_of' => $this->observation->number_of,
            'note' => $this->observation->note,
            'project' => $this->observation->project,
            'habitat' => $this->observation->habitat,
            'found_on' => $this->observation->found_on,
            'found_dead' => $this->observation->found_dead,
            'found_dead_note' => $this->observation->found_dead_note,
            'data_license' => $this->license,
            'status' => $this->status,
            'activity' => $this->activity,
            'types' => $this->observation->types,
            'observed_by_id' => $this->observed_by_id,
            'observed_by' => $this->observedBy,
            'identified_by_id' => $this->identified_by_id,
            'identified_by' => $this->identifiedBy,
            'dataset' => $this->observation->dataset,
            'atlas_code' => $this->observation->atlas_code,
            'observers' => $this->observation->observers,
            'description' => $this->observation->description,
            'comment' => $this->observation->comment,
            'data_provider' => $this->observation->data_provider,
            'data_limit' => $this->observation->data_limit,

            'indigenous' => $this->indigenous,
            'exact_number' => $this->exact_number,
            'locality' => $this->locality,
            'place' => $this->place,
            'municipality' => $this->municipality,
            'data_id' => $this->data_id,
            'folder_id' => $this->folder_id,
            'file' => $this->file,
            'offence_details' => $this->offence_details,
            'in_report' => $this->in_report,
            'case_reported' => $this->case_reported,
            'case_reported_by' => $this->case_reported_by,
            'opportunity' => $this->opportunity,
            'annotation' => $this->annotation,
            'associates' => $this->associates,
            'origin_of_individuals' => $this->origin_of_individuals,
            'cites' => $this->cites,
            'proceeding' => $this->proceeding,
            'verdict' => $this->verdict,
            'verdict_date' => $this->verdict_date,
            'total' => $this->total,
            'dead_from_total' => $this->dead_from_total,
            'alive_from_total' => $this->alive_from_total,
            'sanction_rsd' => $this->sanction_rsd,
            'sanction_eur' => $this->sanction_eur,
            'community_sentence' => $this->community_sentence,
            'case_against' => $this->case_against,
            'case_against_mb' => $this->case_against_mb,
            'case_against_pib' => $this->case_against_pib,
            'case_submitted_to' => $this->case_submitted_to,
            'case_name' => $this->case_name,

            'sources' => $this->sources()->get(),
            'offences' => $this->offences()->get(),
            'suspects' => $this->suspects()->get(),
        ];
    }

    /**
     * Serialize poaching observation to a flat array.
     * Mostly used for the frontend and diffing.
     *
     * @return array
     */
    public function toFlatArray()
    {
        return [
            'id' => $this->id,
            'taxon' => $this->observation->taxon,
            'taxon_id' => $this->observation->taxon_id,
            'taxon_suggestion' => $this->taxon_suggestion,
            'day' => $this->observation->day,
            'month' => $this->observation->month,
            'year' => $this->observation->year,
            'location' => $this->observation->location,
            'latitude' => $this->observation->latitude,
            'longitude' => $this->observation->longitude,
            'mgrs10k' => $this->observation->mgrs10k,
            'accuracy' => $this->observation->accuracy,
            'elevation' => $this->observation->elevation,
            'photos' => $this->observation->photos,
            'observer' => $this->observer,
            'identifier' => $this->identifier,
            'license' => $this->license,
            'sex' => $this->observation->sex,
            'stage_id' => $this->observation->stage_id,
            'number' => $this->observation->number,
            'number_of' => $this->observation->number_of,
            'note' => $this->observation->note,
            'project' => $this->observation->project,
            'habitat' => $this->observation->habitat,
            'found_on' => $this->observation->found_on,
            'found_dead' => $this->observation->found_dead,
            'found_dead_note' => $this->observation->found_dead_note,
            'data_license' => $this->license,
            'status' => $this->status,
            'activity' => $this->activity,
            'types' => $this->observation->types,
            'observed_by_id' => $this->observed_by_id,
            'observed_by' => $this->observedBy,
            'identified_by_id' => $this->identified_by_id,
            'identified_by' => $this->identifiedBy,
            'dataset' => $this->observation->dataset,
            'atlas_code' => $this->observation->atlas_code,
            'observers' => $this->observation->observers,
            'description' => $this->observation->description,
            'comment' => $this->observation->comment,
            'data_provider' => $this->observation->data_provider,
            'data_limit' => $this->observation->data_limit,

            'indigenous' => $this->indigenous,
            'exact_number' => $this->exact_number,
            'locality' => $this->locality,
            'place' => $this->place,
            'municipality' => $this->municipality,
            'data_id' => $this->data_id,
            'folder_id' => $this->folder_id,
            'file' => $this->file,
            'offence_details' => $this->offence_details,
            'in_report' => $this->in_report,
            'case_reported' => $this->case_reported,
            'case_reported_by' => $this->case_reported_by,
            'opportunity' => $this->opportunity,
            'annotation' => $this->annotation,
            'associates' => $this->associates,
            'origin_of_individuals' => $this->origin_of_individuals,
            'cites' => $this->cites,
            'proceeding' => $this->proceeding,
            'verdict' => $this->verdict,
            'verdict_date' => $this->verdict_date,
            'total' => $this->total,
            'dead_from_total' => $this->dead_from_total,
            'alive_from_total' => $this->alive_from_total,
            'sanction_rsd' => $this->sanction_rsd,
            'sanction_eur' => $this->sanction_eur,
            'community_sentence' => $this->community_sentence,
            'case_against' => $this->case_against,
            'case_against_mb' => $this->case_against_mb,
            'case_against_pib' => $this->case_against_pib,
            'case_submitted_to' => $this->case_submitted_to,
            'case_name' => $this->case_name,

            'sources' => $this->sources()->get(),
            'offences' => $this->offences()->get(),
            'suspects' => $this->suspects()->get(),
        ];
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new FieldObservationCollection($models);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->observation->delete();
            $model->activity()->delete();
        });
    }

    public function atlasCode()
    {
        return AtlasCode::findByCode($this->observation->atlas_code);
    }
}
