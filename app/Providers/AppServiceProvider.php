<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
{
    $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
}

    
    public function boot()
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}

}
