<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('admin', function (User $user) {
            return $user->role_id == '1';
        });
        Gate::define('guru', function (User $user) {
            return $user->role_id == '3';
        });
        Gate::define('prodi', function (User $user) {
            return $user->guru && $user->guru->kaprodi()->exists();
        });
        Gate::define('guru_pembimbing', function (User $user) {
            return $user->guru && $user->guru->guru_pembimbing()->exists();
        });
        Gate::define('peserta', function (User $user) {
            return $user->role_id == '4';
        });
    }
}
