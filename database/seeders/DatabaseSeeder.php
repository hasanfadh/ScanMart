<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📦 Created 8 categories');
        $this->command->info('🛍️  Created 30 products');
        $this->command->info('🔐 Admin password: admin123');
    }
}