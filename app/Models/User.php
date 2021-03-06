<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function withRole($role){
        return static::join('roles', 'users.role_id', '=', 'roles.id')->where('roles.name', $role)->get('users.*');
    }

    public function hasRole($roles){
        if(!is_array($roles)) $roles = [$roles];
        
        foreach ($roles as $role) {
            if($this->role->name == $role) return true;
        }
        return false;
    }

    public function role(){ return $this->belongsTo(Role::class); }
}
