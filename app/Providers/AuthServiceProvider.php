<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('manage-suppliers', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_KA_SPPG]);
        });

        \Illuminate\Support\Facades\Gate::define('manage-menus', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_PENGAWAS_GIZI]);
        });

        \Illuminate\Support\Facades\Gate::define('manage-finances', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_PENGAWAS_KEUANGAN]);
        });

        \Illuminate\Support\Facades\Gate::define('manage-distribution', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_ASLAP]);
        });

        \Illuminate\Support\Facades\Gate::define('manage-beneficiaries', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_VOLUNTEER]);
        });

        \Illuminate\Support\Facades\Gate::define('manage-warehouse', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_WAREHOUSE, \App\Models\User::ROLE_PENGAWAS_GIZI]);
        });

        \Illuminate\Support\Facades\Gate::define('view-reports', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_KA_SPPG, \App\Models\User::ROLE_QC, \App\Models\User::ROLE_PENGAWAS_KEUANGAN]);
        });
    }
}
