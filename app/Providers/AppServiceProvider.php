<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Filament\Responses\Auth\CustomLogoutResponse;
use Filament\Responses\Auth\LogoutResponse as LogoutResponseContract;


class AppServiceProvider extends ServiceProvider
{
    
  
    

    
    public function boot()
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}

}
