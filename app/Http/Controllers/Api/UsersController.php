<?php

namespace App\Http\Controllers\Api;

use App\Role;
use App\User;
use App\Taxon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        if (request()->has('page')) {
            return UserResource::collection(
                User::paginate(request('per_page', 15))
            );
        }

        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // New users are created through registration form.
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \App\Http\Resources\UserResource
     */
    public function update(User $user)
    {
        request()->validate([
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'institution' => ['nullable', 'string', 'max:191'],
            'roles_ids' => ['array'],
            'roles_ids.*' => [Rule::in(Role::pluck('id')->all())],
            'curated_taxa_ids' => [
                'array',
                Rule::in(Taxon::pluck('id')->all()),
            ],
        ]);

        $user->update(request(['first_name', 'last_name', 'institution']));

        if (request()->has('roles_ids')) {
            $user->roles()->sync(request('roles_ids', []));
        }

        $user->load('roles');

        if (request()->has('curated_taxa_ids')) {
            $user->curatedTaxa()->sync(
                $user->hasRole('curator') ? request('curated_taxa_ids', []) : []
            );
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
