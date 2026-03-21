<?php

namespace App\Policies;

use App\Models\ExpedienteClinico;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpedienteClinicoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExpedienteClinico $expedienteClinico): bool
    {
         return in_array($user->role, ['admin', 'medico', 'asistente']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return in_array($user->role, ['admin', 'medico']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return false;
    }
}
