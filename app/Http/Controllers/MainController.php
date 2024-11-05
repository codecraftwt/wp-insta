<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WpMaterial;

class MainController extends Controller
{


    public function wpdatacount()
    {
        $data =  WpMaterial::all();

        $plugin = $data->where('type', 'plugin')->count();
        $themes = $data->where('type', 'wp-themes')->count();

        return response([
     
            'plugin' => $plugin,
            'themes' => $themes,
        ]);
    }
}
