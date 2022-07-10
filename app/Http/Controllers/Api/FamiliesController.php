<?php

namespace App\Http\Controllers\Api;

use App\Family;
use App\Http\Requests\StoreFamily;
use App\Http\Resources\FamilyResource;
use Illuminate\Http\Request;

class FamiliesController
{
    public function store(StoreFamily $request)
    {
        return new FamilyResource($request->store());
    }

    public function check(String $name)
    {
        $family = Family::where('name', $name)->firstOrFail();

        return response()->json($family);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $family = Family::find($id);
        $family->name = $request->get('name');
        $family->save();
    }
}
