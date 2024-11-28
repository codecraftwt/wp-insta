<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUser extends Model
{
    use HasFactory;

    protected $table = 'manage_users_table';

    // Fields that are mass assignable
    protected $fillable = ['user_id', 'phone', 'country', 'state', 'city', 'pincode', 'company_name', 'subscription_type', 'start_date', 'end_date', 'status', 'duration', 'subscription_status'];

    /**
     * Get the user that owns the ManageUser.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function manageSites()
    {
        return $this->hasMany(ManageSite::class, 'user_id', 'user_id');
    }
}
