<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks during seeding if needed
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Size::truncate();
        Category::truncate();
        Product::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ===========================
        // Create Admin User
        // ===========================
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@threadline.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create a sample customer
        User::create([
            'name'     => 'Juan Dela Cruz',
            'email'    => 'juan@example.com',
            'password' => Hash::make('password'),
            'phone'    => '09171234567',
            'address'  => '123 Sampaloc Street',
            'city'     => 'Manila',
            'province' => 'Metro Manila',
            'postal_code' => '1000',
            'is_admin' => false,
        ]);

        // ===========================
        // Create Sizes
        // ===========================
        $sizes = [
            ['name' => 'S',   'width' => '19"',   'length' => '26.5"'],
            ['name' => 'M',   'width' => '20"',   'length' => '27"'],
            ['name' => 'L',   'width' => '21.5"', 'length' => '28.2"'],
            ['name' => 'XL',  'width' => '22.5"', 'length' => '29"'],
            ['name' => '2XL', 'width' => '23.5"', 'length' => '30"'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }

        // ===========================
        // Create Ukay Categories
        // ===========================
        $categories = [
            ['name' => 'T-Shirts',    'description' => 'Vintage graphic tees and casual pre-loved shirts'],
            ['name' => 'Polo Shirts', 'description' => 'Classic collared polo shirts from top thrift finds'],
            ['name' => 'Jackets',     'description' => 'Vintage denim, leather, and track jackets'],
            ['name' => 'Hoodies',     'description' => 'Cozy streetwear hoodies and crewnecks'],
            ['name' => 'Pants',       'description' => 'Cargo pants, chinos, and casual trousers'],
            ['name' => 'Jeans',       'description' => 'Classic vintage denim jeans and straight cuts'],
            ['name' => 'Shorts',      'description' => 'Casual thrifted shorts and cargo shorts'],
            ['name' => 'Dresses',     'description' => 'Vintage dresses and floral casual wear'],
            ['name' => 'Skirts',      'description' => 'Pre-loved skirts in various styles'],
            ['name' => 'Bags',        'description' => 'Thrifted shoulder bags, totes, and backpacks'],
            ['name' => 'Shoes',       'description' => 'Vintage sneakers, boots, and casual footwear'],
            ['name' => 'Accessories', 'description' => 'Hats, caps, scarves, and accessories'],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $created = Category::create($cat);
            $categoryMap[$cat['name']] = $created->id;
        }

        // ===========================
        // Create Sample Thrift / Ukay Items (1 of 1 stock = 1)
        // ===========================
        $products = [
            [
                'category_id'  => $categoryMap['Jackets'],
                'name'         => 'Vintage Denim Jacket',
                'brand'        => "Levi's",
                'size_text'    => 'Medium',
                'color'        => 'Washed Blue',
                'condition'    => 'Good',
                'price'        => 450.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => '100% Cotton Denim',
                'measurements' => 'Shoulder: 18", Chest: 21", Length: 27"',
                'description'  => 'Pre-loved Levi\'s denim jacket in good condition. Minor signs of wear adding authentic vintage character.',
            ],
            [
                'category_id'  => $categoryMap['Jackets'],
                'name'         => 'Retro Adidas Track Jacket',
                'brand'        => 'Adidas',
                'size_text'    => 'Large',
                'color'        => 'Black & White',
                'condition'    => 'Excellent',
                'price'        => 750.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => 'Polyester Blend',
                'measurements' => 'Chest: 22", Length: 28"',
                'description'  => 'Pre-loved classic Adidas 3-stripe track jacket in excellent vintage condition. Clean zip and ribbed collar.',
            ],
            [
                'category_id'  => $categoryMap['T-Shirts'],
                'name'         => 'Oversized Graphic Tee',
                'brand'        => 'Nike',
                'size_text'    => 'XL',
                'color'        => 'Black',
                'condition'    => 'Excellent',
                'price'        => 250.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => '100% Heavyweight Cotton',
                'measurements' => 'Chest: 23.5", Length: 29.5"',
                'description'  => 'Heavyweight graphic tee with faded vintage print. Soft hand feel with relaxed boxy drop-shoulder fit.',
            ],
            [
                'category_id'  => $categoryMap['Polo Shirts'],
                'name'         => 'Vintage Polo Shirt',
                'brand'        => 'Uniqlo',
                'size_text'    => 'Medium',
                'color'        => 'Navy Blue',
                'condition'    => 'Good',
                'price'        => 350.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => 'Cotton Pique',
                'measurements' => 'Shoulder: 17.5", Chest: 20", Length: 27"',
                'description'  => 'Classic pre-loved Uniqlo collared polo shirt. Minimalist clean style with two-button placket.',
            ],
            [
                'category_id'  => $categoryMap['Pants'],
                'name'         => 'Baggy Cargo Pants',
                'brand'        => 'Dickies',
                'size_text'    => 'Size 32',
                'color'        => 'Olive Green',
                'condition'    => 'Excellent',
                'price'        => 500.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => 'Cotton Twill',
                'measurements' => 'Waist: 32", Inseam: 30", Leg Opening: 8.5"',
                'description'  => 'Durable vintage Dickies cargo trousers with multi-pocket utility setup. Relaxed baggy fit.',
            ],
            [
                'category_id'  => $categoryMap['Jeans'],
                'name'         => 'Classic Denim Jeans',
                'brand'        => 'Wrangler',
                'size_text'    => 'Size 30',
                'color'        => 'Medium Indigo',
                'condition'    => 'Good',
                'price'        => 400.00,
                'stock'        => 1,
                'featured'     => false,
                'material'     => '100% Cotton Denim',
                'measurements' => 'Waist: 30", Inseam: 31", Rise: 11"',
                'description'  => 'Straight leg vintage Wrangler jeans. Genuine leather patch back detail with natural fade marks.',
            ],
            [
                'category_id'  => $categoryMap['Hoodies'],
                'name'         => 'Thrifted Hoodie',
                'brand'        => 'Champion',
                'size_text'    => 'Large',
                'color'        => 'Heather Grey',
                'condition'    => 'New / Like New',
                'price'        => 550.00,
                'stock'        => 1,
                'featured'     => true,
                'material'     => 'Heavyweight Fleece',
                'measurements' => 'Chest: 22.5", Length: 28.5"',
                'description'  => 'Reverse weave Champion hoodie with sleeve logo patch. Cozy fleece lining with thick drawstring hood.',
            ],
            [
                'category_id'  => $categoryMap['Bags'],
                'name'         => 'Vintage Shoulder Bag',
                'brand'        => 'Thrift Find',
                'size_text'    => 'One Size',
                'color'        => 'Brown Canvas',
                'condition'    => 'Good',
                'price'        => 300.00,
                'stock'        => 1,
                'featured'     => false,
                'material'     => 'Canvas & Faux Leather',
                'measurements' => 'Width: 12", Height: 10", Depth: 4"',
                'description'  => 'Pre-loved vintage cross-body shoulder bag with brass buckles and multiple compartment zippers.',
            ],
        ];

        foreach ($products as $pData) {
            Product::create($pData);
        }
    }
}
