<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Laptop',
                'price' => 15000,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phone',
                'price' => 8000,
                'stock' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headphones',
                'price' => 1200,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}