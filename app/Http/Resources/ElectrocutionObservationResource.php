<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ElectrocutionObservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $electrocutionObservation = parent::toArray($request);

        $electrocutionObservation['photos'] = PhotoResource::collection($electrocutionObservation['photos']);

        return $electrocutionObservation;
    }
}
