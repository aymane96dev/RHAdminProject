<?php

namespace App\Policies;

use App\Contrat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContratPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contrat  $contrat
     * @return mixed
     */
    public function view(User $user)
    {
        return ($user->role === 'administrateur');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contrat  $contrat
     * @return mixed
     */
    public function update(User $user, Contrat $contrat)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contrat  $contrat
     * @return mixed
     */
    public function delete(User $user, Contrat $contrat)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contrat  $contrat
     * @return mixed
     */
    public function restore(User $user, Contrat $contrat)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Contrat  $contrat
     * @return mixed
     */
    public function forceDelete(User $user, Contrat $contrat)
    {
        //
    }
}
