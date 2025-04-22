<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'title' => 'Fashion',
                'description' => 'Clothing, shoes, and accessories.',
                'order' => 1
            ],
            [
                'title' => 'Home',
                'description' => 'Appliances, furniture, and home decor.',
                'order' => 2
            ],
            [
                'title' => 'Kitchen',
                'description' => 'All kinds of kitchen materials.',
                'order' => 3
            ],
            [
                'title' => 'Electronics',
                'description' => 'All kinds of electronic materials.',
                'order' => 4
            ],
        ];

        // Add slugs before inserting
        $categories = array_map(function ($category) {
            $category['slug'] = Str::slug($category['title']);
            return $category;
        }, $categories);

        DB::table('product_categories')->insert($categories);
    }
}
