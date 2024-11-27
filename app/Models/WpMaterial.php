<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpMaterial extends Model
{
    protected $table = 'wp_material';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
        'name',
        'description',
        'file_path',
        'status',
        'category_id',
        'slug'

    ];
    public function category()
    {
        return $this->belongsTo(PluginCategoriesModel::class, 'category_id', 'id');
    }

    /**
     * Define the relationship with ThemesCategoriesModel.
     */
    public function themecategory()
    {
        return $this->belongsTo(ThemesCategoriesModel::class, 'category_id', 'id');
    }
}
