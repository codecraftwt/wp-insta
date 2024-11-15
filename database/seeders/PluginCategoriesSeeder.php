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
            'Social Media',
            'Speed',
            'Forms',
            'Backups',
            'Page Builders',
            'Marketing',
            'eCommerce',
            'Translation',
            'Customer Service',
            'LMS',
        ];

        foreach ($categories as $category) {
            PluginCategoriesModel::create([
                'name' => $category,
            ]);
        }
    }
}
