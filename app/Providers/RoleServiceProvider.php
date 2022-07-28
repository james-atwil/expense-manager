<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::if('role', function ($roles) {
            /** @var User $user */
            $user = auth()->user();

            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }

            return false;
        });
    }
}
