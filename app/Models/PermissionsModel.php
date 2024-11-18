<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsModel extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'guard_name'
    ];

    // Relationship with Role model via role_has_permissions table
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    // Relationship with User model via model_has_permissions table
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_has_permissions', 'model_id', 'permission_id');
    }
}
