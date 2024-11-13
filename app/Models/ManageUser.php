<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUser extends Model
{
    use HasFactory;

    protected $table = 'manage_users_table';

    // Fields that are mass assignable
    protected $fillable = ['user_id', 'phone', 'country', 'state', 'city', 'pincode', 'gender', 'dob', 'subscription_type', 'start_date', 'end_date', 'status', 'duration'];

    /**
     * Get the user that owns the ManageUser.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
