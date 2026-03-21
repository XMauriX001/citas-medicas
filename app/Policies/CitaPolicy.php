<?php

namespace App\Policies;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CitaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cita $cita): bool
    {
        if ($user->role === 'medico') {
            return $cita->medico_id === $user->id;
        }
        return in_array($user->role, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return in_array($user->role, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cita $cita): bool
    {
        return in_array($user->role, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cita $cita): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cita $cita): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cita $cita): bool
    {
        return false;
    }
}
