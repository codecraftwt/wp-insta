<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PluginCategoriesModel;

class PluginCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Popular',
            'Security',
            'SEO',
            'Editing Tools',
            'Forms',
            'Page Builders',
            'Marketing',
            'eCommerce',
            'LMS',
        ];

        foreach ($categories as $category) {
            PluginCategoriesModel::create([
                'name' => $category,
            ]);
        }
    }
}