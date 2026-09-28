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
            'address'  => '123 Sample Street',
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
        // Create Categories
        // ===========================
        $categories = [
            ['name' => 'T-Shirts',    'description' => 'Premium graphic and plain tees'],
            ['name' => 'Shorts',      'description' => 'Comfortable everyday shorts'],
            ['name' => 'Pants',       'description' => 'Stylish and durable pants'],
            ['name' => 'Hoodies',     'description' => 'Cozy hoodies for every season'],
            ['name' => 'Hats',        'description' => 'Caps, beanies, and bucket hats'],
            ['name' => 'Accessories', 'description' => 'Bags, socks, and more'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ===========================
        // Create Products
        // ===========================
        $products = [
            // T-Shirts
            [
                'category_id' => 1,
                'name'        => 'Shadow Graphic Tee',
                'description' => 'A bold graphic tee featuring an abstract shadow print. Made from premium cotton for all-day comfort. Perfect for casual streetwear looks.',
                'price'       => 795.00,
                'material'    => '100% Cotton',
                'stock'       => 50,
                'featured'    => true,
            ],
            [
                'category_id' => 1,
                'name'        => 'Motion Oversized Tee',
                'description' => 'Relaxed oversized fit with a minimalist motion logo. Drop shoulders and extended length for that modern silhouette.',
                'price'       => 895.00,
                'material'    => 'Cotton Blend',
                'stock'       => 40,
                'featured'    => true,
            ],
            [
                'category_id' => 1,
                'name'        => 'Horizon Stripe Tee',
                'description' => 'Clean horizontal stripe pattern on soft cotton. A timeless piece that goes with everything in your wardrobe.',
                'price'       => 745.00,
                'material'    => '100% Cotton',
                'stock'       => 35,
                'featured'    => false,
            ],
            [
                'category_id' => 1,
                'name'        => 'Drift Washed Tee',
                'description' => 'Vintage washed finish gives this tee a lived-in feel. Soft hand feel with a slightly faded aesthetic.',
                'price'       => 995.00,
                'material'    => 'Organic Cotton',
                'stock'       => 25,
                'featured'    => true,
            ],

            // Shorts
            [
                'category_id' => 2,
                'name'        => 'Core Black Shorts',
                'description' => 'Essential black shorts with elastic waistband and drawstring. Features side pockets and a clean silhouette.',
                'price'       => 895.00,
                'material'    => 'Polyester Blend',
                'stock'       => 30,
                'featured'    => true,
            ],
            [
                'category_id' => 2,
                'name'        => 'Urban Utility Shorts',
                'description' => 'Cargo-inspired utility shorts with multiple pockets. Durable construction meets modern streetwear design.',
                'price'       => 1095.00,
                'material'    => 'Cotton Twill',
                'stock'       => 25,
                'featured'    => false,
            ],

            // Pants
            [
                'category_id' => 3,
                'name'        => 'Stealth Cargo Pants',
                'description' => 'Tapered cargo pants with a modern slim fit. Side cargo pockets with snap closures for a sleek look.',
                'price'       => 1495.00,
                'material'    => 'Cotton Twill',
                'stock'       => 20,
                'featured'    => true,
            ],
            [
                'category_id' => 3,
                'name'        => 'Drift Wide Leg Pants',
                'description' => 'Relaxed wide-leg silhouette for maximum comfort. Elastic waistband with an adjustable drawstring.',
                'price'       => 1295.00,
                'material'    => 'Cotton Blend',
                'stock'       => 15,
                'featured'    => false,
            ],

            // Hoodies
            [
                'category_id' => 4,
                'name'        => 'Essential Hoodie',
                'description' => 'Your go-to heavyweight hoodie. Fleece-lined interior, kangaroo pocket, and adjustable hood. Built for comfort.',
                'price'       => 1495.00,
                'material'    => 'Cotton Fleece',
                'stock'       => 30,
                'featured'    => true,
            ],
            [
                'category_id' => 4,
                'name'        => 'Phantom Zip-Up Hoodie',
                'description' => 'Full-zip hoodie with a clean minimal design. Features ribbed cuffs and hem for a snug fit.',
                'price'       => 1695.00,
                'material'    => 'French Terry',
                'stock'       => 20,
                'featured'    => true,
            ],

            // Hats
            [
                'category_id' => 5,
                'name'        => 'Classic Bucket Hat',
                'description' => 'Timeless bucket hat silhouette with an embroidered logo. Lightweight and packable for on-the-go style.',
                'price'       => 595.00,
                'material'    => 'Cotton Canvas',
                'stock'       => 40,
                'featured'    => true,
            ],
            [
                'category_id' => 5,
                'name'        => 'Structured Snapback',
                'description' => 'Classic 6-panel snapback cap with embroidered branding. Adjustable snap closure fits all sizes.',
                'price'       => 495.00,
                'material'    => 'Cotton Twill',
                'stock'       => 35,
                'featured'    => false,
            ],

            // Accessories
            [
                'category_id' => 6,
                'name'        => 'Everyday Tote Bag',
                'description' => 'Durable canvas tote bag with reinforced handles. Spacious interior for daily essentials.',
                'price'       => 695.00,
                'material'    => 'Heavy Canvas',
                'stock'       => 25,
                'featured'    => false,
            ],
            [
                'category_id' => 6,
                'name'        => 'Logo Crew Socks',
                'description' => 'Comfortable crew-length socks with woven logo detail. Cushioned sole for all-day comfort.',
                'price'       => 295.00,
                'material'    => 'Cotton Blend',
                'stock'       => 60,
                'featured'    => false,
            ],
        ];

        $allSizeIds = Size::pluck('id')->toArray();

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Attach all sizes to clothing items (not accessories)
            if (in_array($product->category_id, [1, 2, 3, 4])) {
                foreach ($allSizeIds as $sizeId) {
                    $product->sizes()->attach($sizeId, ['stock' => rand(5, 20)]);
                }
            }
        }
    }
}
