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
        // 1. Supplier: aslap
        \Illuminate\Support\Facades\Gate::define('manage-suppliers', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_ASLAP]);
        });

        // 2. Perencanaan Menu & Daftar Hidangan: Pengawas Gizi & Ka SPPG
        \Illuminate\Support\Facades\Gate::define('manage-menus', function ($user) {
            return in_array($user->role, [
                \App\Models\User::ROLE_ADMIN, 
                \App\Models\User::ROLE_PENGAWAS_GIZI,
                \App\Models\User::ROLE_KA_SPPG
            ]);
        });

        // 3. Manajemen Penerima Manfaat: Aslap
        \Illuminate\Support\Facades\Gate::define('manage-distribution', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_ASLAP]);
        });

        // 4. Daftar PM Detail / Input PM: All except Warehouse
        \Illuminate\Support\Facades\Gate::define('manage-beneficiaries', function ($user) {
            return $user->role !== \App\Models\User::ROLE_WAREHOUSE;
        });

        // 5. Bahan Baku: Pengawas Keuangan, Gudang, Pengawas Gizi
        \Illuminate\Support\Facades\Gate::define('manage-materials', function ($user) {
            return in_array($user->role, [
                \App\Models\User::ROLE_ADMIN, 
                \App\Models\User::ROLE_PENGAWAS_KEUANGAN, 
                \App\Models\User::ROLE_WAREHOUSE, 
                \App\Models\User::ROLE_PENGAWAS_GIZI
            ]);
        });

        // 6. Gudang & Stok: Gudang & Pengawas Keuangan
        \Illuminate\Support\Facades\Gate::define('manage-warehouse', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_WAREHOUSE, \App\Models\User::ROLE_PENGAWAS_KEUANGAN]);
        });

        // 7. Keuangan (Surat Pesanan, Transaksi, Laporan Cash, LPD2M, SPTJ, BAPSD)
        \Illuminate\Support\Facades\Gate::define('manage-finances', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_PENGAWAS_KEUANGAN]);
        });

        // 8. Management & Monitoring (Staf, Aspirasi, Rute): Ka SPPG, Admin, Pengawas Keuangan
        \Illuminate\Support\Facades\Gate::define('manage-system', function ($user) {
            return in_array($user->role, [\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_KA_SPPG, \App\Models\User::ROLE_PENGAWAS_KEUANGAN]);
        });

        // 9. Laporan Umum (Absensi, Pengaduan): All except Warehouse
        \Illuminate\Support\Facades\Gate::define('view-general-reports', function ($user) {
            return $user->role !== \App\Models\User::ROLE_WAREHOUSE;
        });
    }
}
