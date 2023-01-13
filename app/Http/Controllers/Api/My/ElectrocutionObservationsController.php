<?php

namespace App\Http\Controllers\Api\My;

use App\ElectrocutionObservation;
use App\Http\Resources\ElectrocutionObservationResource;
use Illuminate\Http\Request;

class ElectrocutionObservationsController
{
    /**
     * Get field observations made by the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $result = ElectrocutionObservation::createdBy($request->user())->with([
            'observation.taxon', 'observation.photos', 'activity.causer',
            'observation.types.translations', 'observedBy', 'identifiedBy',
        ])->filter($request)->orderBy('id')->paginate($request->get('per_page', 15));

        return ElectrocutionObservationResource::collection($result);
    }
}
