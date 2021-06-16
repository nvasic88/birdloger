<?php

namespace App\Http\Controllers\Api;

use App\ElectrocutionObservation;
use App\Http\Requests\StoreElectrocutionObservation;
use App\Http\Requests\UpdateElectrocutionObservation;
use App\Http\Resources\ElectrocutionObservationResource;
use Illuminate\Http\Request;

class ElectrocutionObservationsController
{
    /**
     * Get field observations.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $result = ElectrocutionObservation::with([
            'observation.taxon', 'observation.photos', 'activity.causer',
            'observation.types.translations', 'observedBy', 'identifiedBy',
        ])->filter($request)->orderBy('id')->paginate($request->get('per_page', 15));

        return ElectrocutionObservationResource::collection($result);
    }

    /**
     * Add new field observation.
     *
     * @param \App\Http\Requests\StoreElectrocutionObservation $form
     * @return \App\Http\Resources\ElectrocutionObservationResource
     */
    public function store(StoreElectrocutionObservation $form)
    {
        return new ElectrocutionObservationResource($form->store());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return \App\Http\Resources\ElectrocutionObservationResource
     */
    public function show(ElectrocutionObservation $electrocutionObservation)
    {
        return new ElectrocutionObservationResource($electrocutionObservation);
    }

    /**
     * Update field observation.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @param \App\Http\Requests\UpdateElectrocutionObservation $form
     * @return \App\Http\Resources\ElectrocutionObservationResource
     */
    public function update(ElectrocutionObservation $electrocutionObservation, UpdateElectrocutionObservation $form)
    {
        return new ElectrocutionObservationResource($form->save($electrocutionObservation));
    }

    /**
     * Delete field observation.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ElectrocutionObservation $electrocutionObservation)
    {
        $electrocutionObservation->delete();

        return response()->json(null, 204);
    }
}
