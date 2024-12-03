<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role_id',
        'notification_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function manageUsers()
    {
        return $this->hasMany(ManageUser::class, 'user_id', 'id');
    }

    public function manageSites()
    {
        return $this->hasMany(ManageSite::class, 'user_id', 'id');
    }

    public function hasPermission($permission)
    {
        // Get the user's role
        $role = $this->role;

        // If the user does not have a role, return false
        if (!$role) {
            return false;
        }

        // Check if the permission exists for the role
        $permissionExists = $role->permissions()->where('name', $permission)->exists();

        // Check for direct user permission (if necessary)
        if ($permissionExists) {
            return true;
        }

        // Optionally, check if the user has a direct permission (via a pivot table or direct user assignment)
        $directPermissionExists = $this->permissions()->where('name', $permission)->exists();

        return $directPermissionExists;
    }
}
