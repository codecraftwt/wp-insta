<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginCategoriesModel extends Model
{
    use HasFactory;

    protected $table = 'plugin_categories_table';

    protected $fillable = [
        'name'
    ];

    public function materials()
    {
        return $this->hasMany(WpMaterial::class, 'category_id', 'id'); // Define relationship with WpMaterial
    }
}
