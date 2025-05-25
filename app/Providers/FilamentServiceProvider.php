<?php

namespace App\Providers;

use Filament\Panel;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Filament::registerPanels([
            Panel::make()
                ->id('admin')
                ->path('admin') // This must match your redirect
                ->login()
                ->homeUrl('/admin')
                ->middleware([
                    'web',
                    // add any custom middleware here
                ])
                ->authMiddleware([
                    'web',
                ])
                ->plugins([
                    // add plugins if needed
                ]),
        ]);
    }

    public function boot(): void
    {
        // Optional: add gate check here
        // Only allow users with role_id == 1
        Gate::define('viewFilament', function ($user) {
            return $user->role_id == 1;
        });

        Filament::serving(function () {
            if (Gate::denies('viewFilament')) {
                abort(403);
            }
        });
    }
}



