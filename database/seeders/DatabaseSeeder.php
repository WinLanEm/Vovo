<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = Category::factory(20)->create();

        foreach(range(1, 10) as $chunk) {
            Product::factory(1000)->create([
                'category_id' => $categories->random()->id,
            ]);
            $this->command->info("Seeded: 1000");
        }
    }
}
