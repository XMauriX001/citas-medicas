<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cita;
use App\Models\User;
use App\Models\ExpedienteClinico;
use App\Policies\CitaPolicy;
use App\Policies\UserPolicy;
use App\Policies\ExpedienteClinicoPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Cita::class, CitaPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(ExpedienteClinico::class, ExpedienteClinicoPolicy::class);
    }
}
