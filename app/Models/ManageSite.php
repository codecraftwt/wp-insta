<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ManageSite extends Model
{


    protected $table = 'site_name_table';



    protected $fillable = [
        'user_id',
        'folder_name',
        'site_name',
        'site_type',
        'version',
        'themes',
        'plugin',
        'email',
        'user_name',
        'password',
        'domain_name',
        'owner_domain_name',
        'login_url',
        'db_name',
        'db_user_name',
        'db_password',
        'created_at',
        'updated_at',
        'status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manageUser()
    {
        return $this->belongsTo(ManageUser::class, 'user_id', 'user_id');
    }
}
