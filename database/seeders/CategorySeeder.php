<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Snacks',
                'slug' => 'snacks',
                'description' => 'Delicious snacks for every occasion',
                'icon' => '🍿',
                'is_active' => true,
            ],
            [
                'name' => 'Drinks',
                'slug' => 'drinks',
                'description' => 'Refreshing beverages and drinks',
                'icon' => '🥤',
                'is_active' => true,
            ],
            [
                'name' => 'Breakfast',
                'slug' => 'breakfast',
                'description' => 'Start your day with healthy breakfast items',
                'icon' => '🍞',
                'is_active' => true,
            ],
            [
                'name' => 'Personal Care',
                'slug' => 'personal-care',
                'description' => 'Daily hygiene and personal care products',
                'icon' => '🧴',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Products',
                'slug' => 'dairy-products',
                'description' => 'Fresh milk, cheese, and dairy items',
                'icon' => '🥛',
                'is_active' => true,
            ],
            [
                'name' => 'Instant Food',
                'slug' => 'instant-food',
                'description' => 'Quick and easy instant meals',
                'icon' => '🍜',
                'is_active' => true,
            ],
            [
                'name' => 'Frozen Food',
                'slug' => 'frozen-food',
                'description' => 'Frozen meals and ingredients',
                'icon' => '🧊',
                'is_active' => true,
            ],
            [
                'name' => 'Household',
                'slug' => 'household',
                'description' => 'Home cleaning and household items',
                'icon' => '🧹',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}