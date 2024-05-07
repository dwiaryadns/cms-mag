<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(PromotionSeeder::class);
        $this->call(ListBranchesSeeder::class);

        // Promotion::factory(100000)->create();
    }
}
