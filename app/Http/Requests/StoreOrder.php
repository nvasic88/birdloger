<?php

namespace App\Http\Requests;

use App\Order;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function save(Order $order)
    {
        $order->fill(array_merge(
            array_map(
                'trim',
                $this->only(['name'])
            )
        ))->save();

        return $order;
    }

    public function store()
    {
        $order = Order::create(
            array_merge(
                array_map(
                    'trim',
                    $this->only(['name'])
                )
            )
        );

        return $order;
    }
}
