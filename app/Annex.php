<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annex extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $fillable = ['name'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
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
            'name' => $this->name
        ];
    }

}
