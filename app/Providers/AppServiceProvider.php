<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
{
    if ($this->app->environment('local')) {
        $this->app->register(DebugbarServiceProvider::class);
    }
}

    
    public function boot()
    {
        Appointment::observe(AppointmentObserver::class);
        
    }


}
