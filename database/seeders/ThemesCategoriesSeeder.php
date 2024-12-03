<?php

namespace Database\Seeders;

use App\Models\ThemesCategoriesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Corporate',
            'Business',
            'Agency',
            'IT (Light)',
            'Lawer',
            'IT (Dark)',
            'Course',
            'Industry',
            'Hotel',
            'Space',
         
        ];

        foreach ($categories as $category) {
            ThemesCategoriesModel::create([
                'name' => $category,
            ]);
        }
    }
}
