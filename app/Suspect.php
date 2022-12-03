<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $fillable = ['name', 'place', 'profile', 'phone', 'email', 'social_media', 'note', 'poaching_observation_id'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'place' => $this->place,
            'profile' => $this->profile,
            'phone' => $this->phone,
            'email' => $this->email,
            'social_media' => $this->social_media,
            'note' => $this->note,
        ];
    }

    /**
     * Serialize field observation to a flat array.
     * Mostly used for the frontend and diffing.
     *
     * @return array
     */
    public function toFlatArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'place' => $this->place,
            'profile' => $this->profile,
            'phone' => $this->phone,
            'email' => $this->email,
            'social_media' => $this->social_media,
            'note' => $this->note,
        ];
    }
}
