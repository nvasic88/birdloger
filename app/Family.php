<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $fillable = ['name', 'order_id'];

    /**
     * One family belong to one order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

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
            'order' => $this->order,
            'order_id' => $this->order_id,
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
            'order' => $this->order,
            'order_id' => $this->order_id,
        ];
    }
}
