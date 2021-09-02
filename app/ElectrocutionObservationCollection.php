<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ElectrocutionObservationCollection extends Collection
{
    /**
     * Get ids of Observation models connected to ElectrocutionObservation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getObservationIds()
    {
        return $this->pluck('observation.id');
    }

    /**
     * Get ids of ElectrocutionObservation models.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getIds()
    {
        return $this->pluck('id');
    }

    /**
     * Approve all electrocution observations.
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

        ElectrocutionObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => false,
            'updated_at' => $now,
        ]);
    }

    /**
     * Mark all electrocution observations as unidentifiable.
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

        ElectrocutionObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => true,
            'updated_at' => $now,
        ]);
    }

    /**
     * Move all electrocution observations to pending.
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

        ElectrocutionObservation::whereIn('id', $this->getIds())->update([
            'unidentifiable' => false,
            'updated_at' => $now,
        ]);
    }
}
