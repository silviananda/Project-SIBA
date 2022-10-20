<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Himpunan extends Authenticatable
{
    use Notifiable;

    protected $table = 'himpunan';
    protected $guard = 'himpunan';

    protected $fillable = [
        'name', 'user_id', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('name', $permission)->first() ?: false;
    }
}
