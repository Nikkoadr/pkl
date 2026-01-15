<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Sidang_pkl;

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
            return $user->role_id == 1;
        });

        Gate::define('guru', function (User $user) {
            return $user->role_id == 3;
        });

        Gate::define('prodi', function (User $user) {
            return $user->guru && $user->guru->kaprodi()->exists();
        });

        Gate::define('guru_pembimbing', function (User $user) {

            if ($user->role_id == 1) {
                return false;
            }

            if ($user->guru && $user->guru->kaprodi()->exists()) {
                return false;
            }

            return $user->guru
                && $user->guru->guru_pembimbing()->exists();
        });
        Gate::define('guru_penguji', function (User $user) {

            if ($user->role_id == 1) {
                return false;
            }

            if (!$user->guru) {
                return false;
            }

            if ($user->guru->kaprodi()->exists()) {
                return false;
            }

            if ($user->guru->guru_pembimbing()->exists()) {
                return false;
            }

            return Sidang_pkl::where('guru_id', $user->guru->id)->exists();
        });


        Gate::define('peserta', function (User $user) {
            return $user->role_id == 4;
        });
    }
}
