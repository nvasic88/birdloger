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
        $order = Order::where('name', $request->name)->firstOrFail();

        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $order = Order::find($id);
        $order->name = $request->get('name');
        $order->save();
    }
}
