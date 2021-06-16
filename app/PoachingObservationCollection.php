<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class PoachingObservationCollection extends Collection
{
    /**
     * Get ids of Observation models connected to PoachingObservation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getObservationIds()
    {
        return $this->pluck('observation.id');
    }

    /**
     * Get ids of PoachingObservation models.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getIds()
    {
        return $this->pluck('id');
    }

    /**
     * Approve all poaching observations.
     *
     * @return void
     */
    public function approve()
    {
        $now = Carbon::now();

        Observation::whereIn('id', $this->getObservationIds())->update([
            'approved_at' => $now,
            'updated_at' => $now,
        ]);

        PoachingObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => false,
            'updated_at' => $now,
        ]);
    }

    /**
     * Mark all poaching observations as unidentifiable.
     *
     * @return void
     */
    public function markAsUnidentifiable()
    {
        $now = Carbon::now();

        Observation::whereIn('id', $this->getObservationIds())->update([
            'approved_at' => null,
            'updated_at' => $now,
        ]);

        PoachingObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => true,
            'updated_at' => $now,
        ]);
    }

    /**
     * Move all poaching observations to pending.
     *
     * @return void
     */
    public function moveToPending()
    {
        $now = Carbon::now();

        Observation::whereIn('id', $this->getObservationIds())->update([
            'approved_at' => null,
            'updated_at' => $now,
        ]);

        PoachingObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => false,
            'updated_at' => $now,
        ]);
    }
}
