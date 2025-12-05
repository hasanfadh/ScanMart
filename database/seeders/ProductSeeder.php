<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Snacks
            [
                'category' => 'snacks',
                'name' => 'Potato Chips Original',
                'description' => 'Crispy potato chips with original flavor',
                'price' => 15000,
                'stock' => 50,
                'weight' => '100g',
                'pickup_location' => 'Aisle 1, Shelf A',
            ],
            [
                'category' => 'snacks',
                'name' => 'Chocolate Wafer',
                'description' => 'Crunchy wafer filled with chocolate cream',
                'price' => 8500,
                'stock' => 75,
                'weight' => '75g',
                'pickup_location' => 'Aisle 1, Shelf A',
            ],
            [
                'category' => 'snacks',
                'name' => 'Cheese Crackers',
                'description' => 'Savory cheese flavored crackers',
                'price' => 12000,
                'stock' => 60,
                'weight' => '120g',
                'pickup_location' => 'Aisle 1, Shelf B',
            ],
            [
                'category' => 'snacks',
                'name' => 'Peanuts Roasted',
                'description' => 'Roasted peanuts with salt',
                'price' => 10000,
                'stock' => 40,
                'weight' => '150g',
                'pickup_location' => 'Aisle 1, Shelf B',
            ],

            // Drinks
            [
                'category' => 'drinks',
                'name' => 'Mineral Water',
                'description' => 'Pure mineral water',
                'price' => 5000,
                'stock' => 100,
                'weight' => '600ml',
                'pickup_location' => 'Aisle 2, Shelf A',
            ],
            [
                'category' => 'drinks',
                'name' => 'Orange Juice',
                'description' => 'Fresh orange juice in bottle',
                'price' => 12000,
                'stock' => 45,
                'weight' => '500ml',
                'pickup_location' => 'Aisle 2, Shelf A',
            ],
            [
                'category' => 'drinks',
                'name' => 'Green Tea',
                'description' => 'Refreshing green tea drink',
                'price' => 8000,
                'stock' => 55,
                'weight' => '350ml',
                'pickup_location' => 'Aisle 2, Shelf B',
            ],
            [
                'category' => 'drinks',
                'name' => 'Cola Soft Drink',
                'description' => 'Classic cola carbonated drink',
                'price' => 7000,
                'stock' => 80,
                'weight' => '330ml',
                'pickup_location' => 'Aisle 2, Shelf B',
            ],

            // Breakfast
            [
                'category' => 'breakfast',
                'name' => 'Whole Wheat Bread',
                'description' => 'Healthy whole wheat bread loaf',
                'price' => 18000,
                'stock' => 30,
                'weight' => '400g',
                'pickup_location' => 'Aisle 3, Shelf A',
            ],
            [
                'category' => 'breakfast',
                'name' => 'Chocolate Cereal',
                'description' => 'Crunchy chocolate flavored cereal',
                'price' => 35000,
                'stock' => 25,
                'weight' => '500g',
                'pickup_location' => 'Aisle 3, Shelf A',
            ],
            [
                'category' => 'breakfast',
                'name' => 'Strawberry Jam',
                'description' => 'Sweet strawberry jam spread',
                'price' => 22000,
                'stock' => 35,
                'weight' => '250g',
                'pickup_location' => 'Aisle 3, Shelf B',
            ],
            [
                'category' => 'breakfast',
                'name' => 'Honey Pure',
                'description' => 'Natural pure honey',
                'price' => 45000,
                'stock' => 20,
                'weight' => '350g',
                'pickup_location' => 'Aisle 3, Shelf B',
            ],

            // Personal Care
            [
                'category' => 'personal-care',
                'name' => 'Toothpaste Fresh Mint',
                'description' => 'Fresh mint toothpaste for healthy teeth',
                'price' => 15000,
                'stock' => 50,
                'weight' => '150g',
                'pickup_location' => 'Aisle 4, Shelf A',
            ],
            [
                'category' => 'personal-care',
                'name' => 'Shampoo Anti Dandruff',
                'description' => 'Anti dandruff shampoo for healthy hair',
                'price' => 32000,
                'stock' => 40,
                'weight' => '340ml',
                'pickup_location' => 'Aisle 4, Shelf A',
            ],
            [
                'category' => 'personal-care',
                'name' => 'Hand Soap',
                'description' => 'Antibacterial hand soap',
                'price' => 18000,
                'stock' => 60,
                'weight' => '500ml',
                'pickup_location' => 'Aisle 4, Shelf B',
            ],
            [
                'category' => 'personal-care',
                'name' => 'Body Lotion',
                'description' => 'Moisturizing body lotion',
                'price' => 42000,
                'stock' => 30,
                'weight' => '250ml',
                'pickup_location' => 'Aisle 4, Shelf B',
            ],

            // Dairy Products
            [
                'category' => 'dairy-products',
                'name' => 'Fresh Milk',
                'description' => 'Fresh cow milk',
                'price' => 20000,
                'stock' => 45,
                'weight' => '1L',
                'pickup_location' => 'Refrigerator A',
            ],
            [
                'category' => 'dairy-products',
                'name' => 'Cheddar Cheese',
                'description' => 'Premium cheddar cheese',
                'price' => 55000,
                'stock' => 25,
                'weight' => '250g',
                'pickup_location' => 'Refrigerator A',
            ],
            [
                'category' => 'dairy-products',
                'name' => 'Yogurt Strawberry',
                'description' => 'Creamy strawberry yogurt',
                'price' => 12000,
                'stock' => 50,
                'weight' => '150g',
                'pickup_location' => 'Refrigerator B',
            ],
            [
                'category' => 'dairy-products',
                'name' => 'Butter Salted',
                'description' => 'Premium salted butter',
                'price' => 38000,
                'stock' => 30,
                'weight' => '200g',
                'pickup_location' => 'Refrigerator B',
            ],

            // Instant Food
            [
                'category' => 'instant-food',
                'name' => 'Instant Noodles Chicken',
                'description' => 'Quick instant noodles with chicken flavor',
                'price' => 3500,
                'stock' => 100,
                'weight' => '75g',
                'pickup_location' => 'Aisle 5, Shelf A',
            ],
            [
                'category' => 'instant-food',
                'name' => 'Cup Noodles Beef',
                'description' => 'Instant cup noodles with beef flavor',
                'price' => 8000,
                'stock' => 80,
                'weight' => '70g',
                'pickup_location' => 'Aisle 5, Shelf A',
            ],
            [
                'category' => 'instant-food',
                'name' => 'Instant Porridge',
                'description' => 'Quick instant porridge',
                'price' => 7500,
                'stock' => 60,
                'weight' => '50g',
                'pickup_location' => 'Aisle 5, Shelf B',
            ],

            // Frozen Food
            [
                'category' => 'frozen-food',
                'name' => 'Chicken Nuggets',
                'description' => 'Crispy chicken nuggets',
                'price' => 45000,
                'stock' => 35,
                'weight' => '500g',
                'pickup_location' => 'Freezer A',
            ],
            [
                'category' => 'frozen-food',
                'name' => 'Fish Fillet',
                'description' => 'Premium fish fillet',
                'price' => 58000,
                'stock' => 20,
                'weight' => '400g',
                'pickup_location' => 'Freezer A',
            ],
            [
                'category' => 'frozen-food',
                'name' => 'Mixed Vegetables',
                'description' => 'Frozen mixed vegetables',
                'price' => 25000,
                'stock' => 40,
                'weight' => '500g',
                'pickup_location' => 'Freezer B',
            ],

            // Household
            [
                'category' => 'household',
                'name' => 'Dish Soap',
                'description' => 'Effective dish washing soap',
                'price' => 15000,
                'stock' => 50,
                'weight' => '800ml',
                'pickup_location' => 'Aisle 6, Shelf A',
            ],
            [
                'category' => 'household',
                'name' => 'Floor Cleaner',
                'description' => 'Multi-purpose floor cleaner',
                'price' => 28000,
                'stock' => 40,
                'weight' => '1L',
                'pickup_location' => 'Aisle 6, Shelf A',
            ],
            [
                'category' => 'household',
                'name' => 'Laundry Detergent',
                'description' => 'Powerful laundry detergent',
                'price' => 35000,
                'stock' => 45,
                'weight' => '1kg',
                'pickup_location' => 'Aisle 6, Shelf B',
            ],
            [
                'category' => 'household',
                'name' => 'Tissue Box',
                'description' => 'Soft facial tissue',
                'price' => 18000,
                'stock' => 70,
                'weight' => '250 sheets',
                'pickup_location' => 'Aisle 6, Shelf B',
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();
            
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'weight' => $productData['weight'],
                    'pickup_location' => $productData['pickup_location'],
                    'is_active' => true,
                ]);
            }
        }
    }
}