<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreOrder;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

class OrdersController
{
    public function store(StoreOrder $request)
    {
        return new OrderResource($request->store());
    }

    public function check(Request $request)
    {
        $order = Order::where('firstName', $request->firstName)->where('lastName', $request->lastName)->firstOrFail();
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        $order = Order::find($id);
        $order->firstName = $request->get('firstName');
        $order->lastName = $request->get('lastName');
        $order->save();
    }
}
