<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
    use HasFactory;

    protected $table = 'role_has_permissions';
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public $timestamps = false;

    // Define the relationship with PermissionsModel
    public function permissions()
    {
        return $this->belongsTo(PermissionsModel::class, 'permission_id');  // Corrected the relation
    }

    // Define the relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');  // Assuming you have a Role model
    }
}
