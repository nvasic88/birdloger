<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Resources\PoachingObservationResource;
use App\PoachingObservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PoachingObservationsController
{
    /**
     * Get poaching observations made by the user.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $result = PoachingObservation::createdBy($request->user())->with([
            'observation.taxon', 'observation.photos', 'activity.causer',
            'observation.types.translations', 'observedBy', 'identifiedBy',
        ])->filter($request)->orderBy('id')->paginate($request->get('per_page', 15));

        return PoachingObservationResource::collection($result);
    }
}
