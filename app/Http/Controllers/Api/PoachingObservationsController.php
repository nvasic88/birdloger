<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePoachingObservation;
use App\Http\Requests\UpdatePoachingObservation;
use App\Http\Resources\PoachingObservationResource;
use App\PoachingObservation;
use Illuminate\Http\Request;

class PoachingObservationsController
{
    /**
     * Get poaching observations.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $result = PoachingObservation::with([
            'observation.taxon', 'observation.photos', 'activity.causer',
            'observation.types.translations', 'observedBy', 'identifiedBy',
        ])->filter($request)->orderBy('id')->paginate($request->get('per_page', 15));

        return PoachingObservationResource::collection($result);
    }

    /**
     * Add new poaching observation.
     *
     * @param \App\Http\Requests\StorePoachingObservation $form
     * @return \App\Http\Resources\PoachingObservationResource
     */
    public function store(StorePoachingObservation $form)
    {
        return new PoachingObservationResource($form->store());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return \App\Http\Resources\PoachingObservationResource
     */
    public function show(PoachingObservation $poachingObservation)
    {
        return new PoachingObservationResource($poachingObservation);
    }

    /**
     * Update poaching observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @param \App\Http\Requests\UpdatePoachingObservation $form
     * @return \App\Http\Resources\PoachingObservationResource
     */
    public function update(PoachingObservation $poachingObservation, UpdatePoachingObservation $form)
    {
        return new PoachingObservationResource($form->save($poachingObservation));
    }

    /**
     * Delete poaching observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PoachingObservation $poachingObservation)
    {
        $poachingObservation->delete();

        return response()->json(null, 204);
    }
}
