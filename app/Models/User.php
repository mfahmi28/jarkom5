<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    /**
     * Get the role that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function InRole(String $roles_string)
    {
        $user = $this;
        $role_array = explode('|', $roles_string);
        if (isset($user->role->slug)) {
            return in_array($user->role->slug, $role_array);
        }
        return false;
    }


    // todo? - does dynamic permission really needed?
    // This is not really an elegant solution, eitherway better than writing each policy for every permissions
    // public function role_allowed(String $permission)
    // {
    //     if ($this->role) {
    //         return in_array($permission, $this->role->permissions);
    //     }
    //     return false;
    // }

    // public function role_cannot(String $permission)
    // {
    //     if ($this->role) {
    //         return in_array($permission, $this->role->permissions);
    //     }
    //     return false;
    // }
}
