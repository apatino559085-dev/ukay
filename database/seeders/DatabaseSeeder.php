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
    }
}

