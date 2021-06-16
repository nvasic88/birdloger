<?php

namespace App\Policies;

use App\ElectrocutionObservation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElectrocutionObservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the electrocutionObservation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determine whether the user can list the electrocution observation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determine whether the user can create electrocution observation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determine whether the user can update the electrocution observation.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return mixed
     */
    public function update(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $user->hasAnyRole(['admin', 'electrocution'])
            || $this->isCurator($user, $electrocutionObservation)
            || $electrocutionObservation->isCreatedBy($user);
    }

    /**
     * Determine whether the user can delete the electrocution observation.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return mixed
     */
    public function delete(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $electrocutionObservation->isCreatedBy($user) || $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determinte whether the user can approve the electrocution observation.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return bool
     */
    public function approve(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $this->isCurator($user, $electrocutionObservation) || $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determinte whether the user can approve the electrocution observation.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return bool
     */
    public function markAsUnidentifiable(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $this->isCurator($user, $electrocutionObservation) || $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Determinte whether the user can move the electrocution observation to pending.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return bool
     */
    public function moveToPending(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $this->isCurator($user, $electrocutionObservation) || $user->hasAnyRole(['admin', 'electrocution']);
    }

    /**
     * Check if the user is curator for the observed taxon.
     *
     * @param \App\User $user
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return bool
     */
    protected function isCurator(User $user, ElectrocutionObservation $electrocutionObservation)
    {
        return $user->hasAnyRole(['admin', 'electrocution']) && $electrocutionObservation->shouldBeCuratedBy($user);
    }
}
