<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => '売上', 'icon' => '💰', 'default_type' => 'income', 'sort_order' => 1, 'created_at' => now()],
            ['name' => '交通費', 'icon' => '🚃', 'default_type' => 'expense', 'sort_order' => 2, 'created_at' => now()],
            ['name' => '外注費', 'icon' => '🛠️', 'default_type' => 'expense', 'sort_order' => 3, 'created_at' => now()],
        ]);
    }
}
