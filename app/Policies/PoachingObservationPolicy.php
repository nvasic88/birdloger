<?php

namespace App\Policies;

use App\PoachingObservation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoachingObservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the poachingObservation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determine whether the user can list the poaching observation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determine whether the user can create poaching observation.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determine whether the user can update the poaching observation.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return mixed
     */
    public function update(User $user, PoachingObservation $poachingObservation)
    {
        return $user->hasAnyRole(['admin', 'poaching'])
            || $this->isCurator($user, $poachingObservation)
            || $poachingObservation->isCreatedBy($user);
    }

    /**
     * Determine whether the user can delete the poaching observation.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return mixed
     */
    public function delete(User $user, PoachingObservation $poachingObservation)
    {
        return $poachingObservation->isCreatedBy($user) || $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determinte whether the user can approve the poaching observation.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return bool
     */
    public function approve(User $user, PoachingObservation $poachingObservation)
    {
        return $this->isCurator($user, $poachingObservation) || $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determinte whether the user can approve the poaching observation.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return bool
     */
    public function markAsUnidentifiable(User $user, PoachingObservation $poachingObservation)
    {
        return $this->isCurator($user, $poachingObservation) || $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Determinte whether the user can move the poaching observation to pending.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return bool
     */
    public function moveToPending(User $user, PoachingObservation $poachingObservation)
    {
        return $this->isCurator($user, $poachingObservation) || $user->hasAnyRole(['admin', 'poaching']);
    }

    /**
     * Check if the user is curator for the observed taxon.
     *
     * @param \App\User $user
     * @param \App\PoachingObservation $poachingObservation
     * @return bool
     */
    protected function isCurator(User $user, PoachingObservation $poachingObservation)
    {
        return $user->hasAnyRole(['admin', 'poaching']);
    }
}
