<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'id_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function permission()
    {
        return $this->hasMany(Permission::class, 'id_user', 'id');
    }

    public function hasRole($role)
    {
        return $this->role->nama_role == $role;
    }

    public function hasPermission($type, $permission)
    {
        return $this->whereHas('permission', function ($q) use ($type, $permission) {
            $q->where('type', $type)
                ->where($permission, 1);
        })->first();
    }
}
