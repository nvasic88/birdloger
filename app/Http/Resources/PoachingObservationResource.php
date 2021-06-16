<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PoachingObservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $poachingObservation = parent::toArray($request);

        $poachingObservation['photos'] = PhotoResource::collection($poachingObservation['photos']);

        return $poachingObservation;
    }
}
