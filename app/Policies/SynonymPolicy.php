<?php

namespace App\Policies;

use App\Synonym;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SynonymPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the taxon.
     *
     * @param  \App\User  $user
     * @param  \App\Synonym  $synonym
     * @return mixed
     */
    public function view(User $user, Synonym $synonym)
    {
        return true;
    }

    /**
     * Determine whether the user can view the taxon.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create taxons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'curator']);
    }

    /**
     * Determine whether the user can update the taxon.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAnyRole(['admin', 'curator']);
    }

    /**
     * Determine whether the user can delete the taxon.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAnyRole(['admin', 'curator']);
    }
}
