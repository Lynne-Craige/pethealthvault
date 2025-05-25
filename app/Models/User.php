<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel\Contracts\FilamentUser; // ✅ Filament v3.2
use Filament\Models\Contracts\HasName;

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

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // ✅ Customize your admin access logic here
        return $this->roles && $this->roles->name === 'Admin';
    }
}
