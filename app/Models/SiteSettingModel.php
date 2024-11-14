<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettingModel extends Model
{
    protected $table = 'site_setting_table';

    protected $fillable = [
        'site_title',
        'logo',
        'header_background',
        'header_text',
        'header_btncolor',
        'header_btn_bgcolor',
        'footer_text',
        'footer_background',
    ];
}
