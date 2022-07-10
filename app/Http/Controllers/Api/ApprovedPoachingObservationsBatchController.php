<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PoachingObservationResource;
use App\Notifications\PoachingObservationApproved;
use App\PoachingObservation;
use App\Rules\ApprovablePoachingObservation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApprovedPoachingObservationsBatchController
{
    use AuthorizesRequests;

    /**
     * Approve multiple poaching observations.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        request()->validate([
            'poaching_observation_ids' => [
                'required', 'array', 'min:1', new ApprovablePoachingObservation,
            ],
        ]);


        $poachingObservations = $this->getPoachingObservations();

        $poachingObservations->each(function ($poachingObservation) {
            $this->authorize('approve', $poachingObservation);
        });

        $poachingObservations->approve();


        $poachingObservations->each(function ($poachingObservation) {
            $this->logActivity($poachingObservation);
            $this->notifyCreator($poachingObservation);
        });

        return PoachingObservationResource::collection($poachingObservations);
    }

    /**
     * Get poaching observation to approve.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPoachingObservations()
    {
        return PoachingObservation::approvable()->with([
            'observation.creator', 'observation.taxon.curators.roles',
        ])->whereIn('id', request('poaching_observation_ids'))->get();
    }

    /**
     * Log approved activity for poaching observation.
     *
     * @param  \App\PoachingObservation  $poachingObservation
     * @return void
     */
    protected function logActivity(PoachingObservation $poachingObservation)
    {
        activity()->performedOn($poachingObservation)
           ->causedBy(auth()->user())
           ->log('approved');
    }

    /**
     * Notify the creator that the observation is approved.
     *
     * @param  \App\PoachingObservation  $poachingObservation
     * @return void
     */
    private function notifyCreator(PoachingObservation $poachingObservation)
    {
        $user = auth()->user();

        if (! $user->is($poachingObservation->observation->creator)) {
            $poachingObservation->observation->creator->notify(
                new PoachingObservationApproved($poachingObservation, $user)
            );
        }
    }
}
