<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        CartItem::factory(50)->create();
        Order::factory(50)->create();
    }
}
