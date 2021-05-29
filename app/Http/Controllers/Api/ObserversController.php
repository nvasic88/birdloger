<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreObserver;
use App\Http\Resources\ObserverResource;
use App\Observer;
use Illuminate\Http\Request;

class ObserversController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $observer = Observer::with(
            [
                'observations',
            ]
        )->filter($request)->orderBy('id')->paginate($request->input('per_page', 15));

        return ObserverResource::collection($observer);
    }

    public function store(StoreObserver $request)
    {
        return new ObserverResource($request->store());
    }

    public function destroy(int $id)
    {
        $observer = Observer::find($id);
        $observer->observations()->detach();

        return response()->json(null, 204);
    }

    public function update(Observer $observer, StoreObserver $form)
    {
        return new ObserverResource($form->save($observer));
    }
}
