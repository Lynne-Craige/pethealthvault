<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Define who can access Filament
        Gate::define('viewFilament', function ($user) {
            return $user->role_id == 1;
        });

        Filament::serving(function () {
            if (Gate::denies('viewFilament')) {
                abort(403);
            }

            Filament::registerUserMenuItems([
                // Add menu items here
            ]);
        });
    }
}


