<?php

namespace App\Http\Controllers\Api;

use App\FieldObservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFieldObservation;
use App\Http\Requests\UpdateFieldObservation;
use App\Http\Resources\FieldObservation as FieldObservationResource;

class FieldObservationsController extends Controller
{
    /**
     * Get field observations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
     public function index(Request $request)
     {
         $query = FieldObservation::filter($request)->orderBy('id');

         if ($request->has('page')) {
             return FieldObservationResource::collection(
                 $query->paginate($request->input('per_page', 15))
             );
         }

         return FieldObservationResource::collection($query->get());
     }

    /**
     * Add new field observation.
     *
     * @return \App\Http\Resources\FieldObservation
     */
    public function store(StoreFieldObservation $form)
    {
        return new FieldObservationResource($form->save());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FieldObservation  $fieldObservation
     * @return \App\Http\Resources\FieldObservation
     */
    public function show(FieldObservation $fieldObservation)
    {
        return new FieldObservationResource($fieldObservation);
    }

    /**
     * Update field observation.
     *
     * @return \App\Http\Resources\FieldObservation
     */
    public function update(FieldObservation $fieldObservation, UpdateFieldObservation $form)
    {
        return new FieldObservationResource(
            $form->save($fieldObservation)
        );
    }

    /**
     * Delete field observation.
     *
     * @param  \App\FieldObservation  $fieldObservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FieldObservation $fieldObservation)
    {
        $fieldObservation->delete();

        return response()->json(null, 204);
    }
}
