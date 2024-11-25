<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemesCategoriesModel extends Model
{
    use HasFactory;

    protected $table = 'theme_categories_table';

    protected $fillable = [
        'name'
    ];
}
