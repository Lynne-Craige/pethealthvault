<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Filament\Responses\Auth\CustomLogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;

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
