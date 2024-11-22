<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    protected $table = "roles";

    protected $primaryKey  = "id";




    protected $fillable = [
        'name',

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(PermissionsModel::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function getGuardNameAttribute()
    {
        return $this->permissions()->first()?->guard_name ?? 'web';
    }
}
