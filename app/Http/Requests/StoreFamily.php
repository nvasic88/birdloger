<?php

namespace App\Http\Requests;

use App\Family;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamily extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'name' => ['required', 'string'],
        ];
    }

    public function save(Family $family)
    {
        $family->fill(array_merge(
            array_map(
                'trim',
                $this->only(['name', 'order_id'])
            )
        ))->save();
        return $family;
    }

    public function store()
    {
        return Family::create(
            array_merge(
                array_map(
                    'trim',
                    $this->only(['name', 'order_id'])
                )
            )
        );
    }
}
