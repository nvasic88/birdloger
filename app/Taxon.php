<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taxa';

    /**
     * Observations relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function observations()
    {
        return $this->hasMany(Observation::class);
    }

    /**
     * Approved observations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvedObservations()
    {
        return $this->observations()->approved();
    }

    /**
     * Unapproved observations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unapprovedObservations()
    {
        return $this->observations()->unapproved();
    }

    /**
     * Get list of MGRS fields the taxon was observed at.
     *
     * @return array
     */
    public function mgrs()
    {
        return $this->approvedObservations()
            ->pluck('mgrs_field')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Parent relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Taxon::class, 'parent_id');
    }

    /**
     * Ancestors relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ancestors()
    {
        return $this->belongsToMany(Taxon::class, 'taxon_ancestors', 'taxon_id', 'ancestor_id');
    }

    /**
     * Check if taxon is root.
     *
     * @return bool
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if given taxon is child of this taxon.
     *
     * @param  Taxon|integer  $parent
     * @return bool
     */
    public function isChildOf($parent)
    {
        if (is_int($parent)) {
            return $this->parent_id === $parent;
        }

        return $this->parent_id === $parent->id;
    }

    /**
     * Check if given taxon is parent of this taxon.
     *
     * @param  Taxon  $taxon
     * @return bool
     */
    public function isParentOf($taxon)
    {
        return $this->id === $taxon->parent_id ;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if ($model->isRoot()) {
                return;
            }

            $model->ancestors()->attach($model->parent);

            $model->ancestors()->attach($model->parent->ancestors);
        });
    }
}
