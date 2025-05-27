<?php

namespace App\Filament\Responses\Auth;

use Filament\Responses\Auth\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\Request;

class CustomLogoutResponse implements LogoutResponseContract
{
    public function toResponse(Request $request)
    {
        return redirect('/login'); // Custom login route
    }
}
