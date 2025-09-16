<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productJSON = File::get(database_path('data/products.json'));
        $products = json_decode($productJSON, true);

        foreach ($products as $product) {
            // Create the country
            $product = Product::create([
                'id' => $product['id'],
                'name' => $product['name'],
                'sku' => $product['sku'],
                'price' => $product['price'],
            ]);
        }
    }
}
