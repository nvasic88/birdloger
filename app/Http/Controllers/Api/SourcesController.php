<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreSource;
use App\Http\Resources\SourceResource;
use App\Source;

class SourcesController
{
    public function store(StoreSource $request)
    {
        return new SourceResource($request->store());
    }

    public function destroy(int $id)
    {
        $src = Source::find($id);
        $src->delete();

        return response()->json(null, 204);
    }

    public function update(Source $observer, StoreSource $form)
    {
        return new SourceResource($form->save($observer));
    }
}
