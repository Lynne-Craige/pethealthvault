<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel; 


class User extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'barangay_id',
        'phone_number',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'UserID');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function getFilamentName(): string
    {
        return trim("{$this->firstname} {$this->lastname}");
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role_id === 1;
    }
}
