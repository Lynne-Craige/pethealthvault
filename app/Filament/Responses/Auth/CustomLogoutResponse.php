<?php

namespace App\Filament\Responses\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\Request;

class CustomLogoutResponse implements LogoutResponseContract
{
    public function toResponse(Request $request)
    {
        return redirect('/PHV-login'); // Your custom login page
    }
}
