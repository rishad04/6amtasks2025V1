<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $products = [
            [
                'banner' => 'assets/images/products/fashion-1.png',
                'title' => 'Sunglass',
                'product_category_id' => ProductCategory::where('slug', 'fashion')->value('id'),
                'price' => 1500,
                'stock_quantity' => 20,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Cool fashion shades.',
            ],
            [
                'banner' => 'assets/images/products/fashion-2.png',
                'title' => 'Watch',
                'product_category_id' => ProductCategory::where('slug', 'fashion')->value('id'),
                'price' => 3000,
                'stock_quantity' => 40,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Elegant & timeless.',
            ],
            [
                'banner' => 'assets/images/products/electronic-1.png',
                'title' => 'Camera Lens',
                'product_category_id' => ProductCategory::where('slug', 'electronics')->value('id'),
                'price' => 12000,
                'stock_quantity' => 10,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Pro lens gear.',
            ],
            [
                'banner' => 'assets/images/products/home-1.png',
                'title' => 'Table Light',
                'product_category_id' => ProductCategory::where('slug', 'home')->value('id'),
                'price' => 3400,
                'stock_quantity' => 10,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Modern workspace lighting.',
            ],
            [
                'banner' => 'assets/images/products/home-2.png',
                'title' => 'Table',
                'product_category_id' => ProductCategory::where('slug', 'home')->value('id'),
                'price' => 7000,
                'stock_quantity' => 10,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Sturdy wooden table.',
            ],
            [
                'banner' => 'assets/images/products/home-3.png',
                'title' => 'Flower Vase',
                'product_category_id' => ProductCategory::where('slug', 'home')->value('id'),
                'price' => 1200,
                'stock_quantity' => 100,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Decor for your space.',
            ],
            [
                'banner' => 'assets/images/products/kitchen-1.png',
                'title' => 'Cup Set',
                'product_category_id' => ProductCategory::where('slug', 'kitchen')->value('id'),
                'price' => 400,
                'stock_quantity' => 12,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Ceramic drinkware.',
            ],
            [
                'banner' => 'assets/images/products/kitchen-2.png',
                'title' => 'Glass Set',
                'product_category_id' => ProductCategory::where('slug', 'kitchen')->value('id'),
                'price' => 1500,
                'stock_quantity' => 12,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Elegant glassware.',
            ],
            [
                'banner' => 'assets/images/products/kitchen-3.png',
                'title' => 'Water Bottle',
                'product_category_id' => ProductCategory::where('slug', 'kitchen')->value('id'),
                'price' => 300,
                'stock_quantity' => 1500,
                'is_popular' => 1,
                'description' => $faker->paragraph(10),
                'short_description' => 'Stay hydrated.',
            ],
        ];

        // Generate slug for each
        foreach ($products as &$product) {
            $product['slug'] = Str::slug($product['title']);
        }

        DB::table('products')->insert($products);

        // Factory data
        Product::factory()->count(8000)->create();
    }
}
