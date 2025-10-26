<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Like;
use App\Models\Recipe;
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
        $this->command->info('🌱 Seeding GetCooked database...');

        // 1. Create test users
        $this->command->info('Creating users...');

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@getcooked.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@getcooked.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        $jane = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@getcooked.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // Additional random users
        $extraUsers = User::factory()->count(3)->create();
        $allUsers = collect([$admin, $user, $jane])->merge($extraUsers);

        $this->command->info("✓ Created {$allUsers->count()} users");

        // 2. Create recipes with different statuses
        $this->command->info('Creating recipes...');

        // Private recipe (user)
        $privateRecipe1 = Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Secret Chocolate Cake',
            'description' => 'A family recipe that has been passed down for generations. Rich, moist, and absolutely delicious!',
            'cook_time' => 45,
            'servings' => 8,
            'status' => 'private',
        ]);

        Ingredient::create(['recipe_id' => $privateRecipe1->id, 'name' => 'Dark Chocolate', 'amount' => 200, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $privateRecipe1->id, 'name' => 'Flour', 'amount' => 300, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $privateRecipe1->id, 'name' => 'Sugar', 'amount' => 250, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $privateRecipe1->id, 'name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces']);

        $privateRecipe2 = Recipe::factory()->create([
            'user_id' => $jane->id,
            'title' => 'Jane\'s Special Smoothie',
            'description' => 'My go-to morning smoothie recipe. Healthy and energizing!',
            'cook_time' => 5,
            'servings' => 1,
            'status' => 'private',
        ]);

        Ingredient::create(['recipe_id' => $privateRecipe2->id, 'name' => 'Banana', 'amount' => 1, 'unit' => 'piece']);
        Ingredient::create(['recipe_id' => $privateRecipe2->id, 'name' => 'Spinach', 'amount' => 50, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $privateRecipe2->id, 'name' => 'Almond Milk', 'amount' => 250, 'unit' => 'ml']);

        // Pending recipes (waiting for approval)
        $pendingRecipe1 = Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => 'Classic Italian Carbonara',
            'description' => 'An authentic Italian carbonara recipe. Creamy, savory, and traditional.',
            'cook_time' => 25,
            'servings' => 4,
            'status' => 'pending',
        ]);

        Ingredient::create(['recipe_id' => $pendingRecipe1->id, 'name' => 'Spaghetti', 'amount' => 400, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $pendingRecipe1->id, 'name' => 'Guanciale', 'amount' => 150, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $pendingRecipe1->id, 'name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces']);
        Ingredient::create(['recipe_id' => $pendingRecipe1->id, 'name' => 'Pecorino Romano', 'amount' => 100, 'unit' => 'g']);

        $pendingRecipe2 = Recipe::factory()->create([
            'user_id' => $jane->id,
            'title' => 'Vegan Buddha Bowl',
            'description' => 'A colorful and nutritious vegan bowl packed with vegetables and grains.',
            'cook_time' => 30,
            'servings' => 2,
            'status' => 'pending',
        ]);

        Ingredient::create(['recipe_id' => $pendingRecipe2->id, 'name' => 'Quinoa', 'amount' => 200, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $pendingRecipe2->id, 'name' => 'Chickpeas', 'amount' => 400, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $pendingRecipe2->id, 'name' => 'Sweet Potato', 'amount' => 1, 'unit' => 'piece']);

        // Approved recipes (public)
        $approvedRecipe1 = Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => 'Perfect Homemade Pizza',
            'description' => 'Learn how to make authentic Neapolitan-style pizza at home. Crispy crust, delicious toppings!',
            'cook_time' => 90,
            'servings' => 4,
            'status' => 'approved',
        ]);

        Ingredient::create(['recipe_id' => $approvedRecipe1->id, 'name' => 'Pizza Flour (00)', 'amount' => 500, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $approvedRecipe1->id, 'name' => 'Water', 'amount' => 325, 'unit' => 'ml']);
        Ingredient::create(['recipe_id' => $approvedRecipe1->id, 'name' => 'Yeast', 'amount' => 7, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $approvedRecipe1->id, 'name' => 'Mozzarella', 'amount' => 250, 'unit' => 'g']);

        $approvedRecipe2 = Recipe::factory()->create([
            'user_id' => $jane->id,
            'title' => 'Thai Green Curry',
            'description' => 'Aromatic Thai green curry with vegetables. Spicy, creamy, and full of flavor!',
            'cook_time' => 40,
            'servings' => 4,
            'status' => 'approved',
        ]);

        Ingredient::create(['recipe_id' => $approvedRecipe2->id, 'name' => 'Green Curry Paste', 'amount' => 3, 'unit' => 'tbsp']);
        Ingredient::create(['recipe_id' => $approvedRecipe2->id, 'name' => 'Coconut Milk', 'amount' => 400, 'unit' => 'ml']);
        Ingredient::create(['recipe_id' => $approvedRecipe2->id, 'name' => 'Chicken Breast', 'amount' => 500, 'unit' => 'g']);

        $approvedRecipe3 = Recipe::factory()->create([
            'user_id' => $extraUsers[0]->id,
            'title' => 'Classic French Croissants',
            'description' => 'Buttery, flaky croissants made from scratch. A labor of love!',
            'cook_time' => 240,
            'servings' => 12,
            'status' => 'approved',
        ]);

        Ingredient::create(['recipe_id' => $approvedRecipe3->id, 'name' => 'Bread Flour', 'amount' => 500, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $approvedRecipe3->id, 'name' => 'Butter', 'amount' => 280, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $approvedRecipe3->id, 'name' => 'Milk', 'amount' => 140, 'unit' => 'ml']);

        $approvedRecipe4 = Recipe::factory()->create([
            'user_id' => $extraUsers[1]->id,
            'title' => 'Beef Tacos with Fresh Salsa',
            'description' => 'Delicious street-style tacos with seasoned beef and homemade salsa.',
            'cook_time' => 35,
            'servings' => 6,
            'status' => 'approved',
        ]);

        Ingredient::create(['recipe_id' => $approvedRecipe4->id, 'name' => 'Ground Beef', 'amount' => 500, 'unit' => 'g']);
        Ingredient::create(['recipe_id' => $approvedRecipe4->id, 'name' => 'Taco Seasoning', 'amount' => 2, 'unit' => 'tbsp']);
        Ingredient::create(['recipe_id' => $approvedRecipe4->id, 'name' => 'Tortillas', 'amount' => 12, 'unit' => 'pieces']);
        Ingredient::create(['recipe_id' => $approvedRecipe4->id, 'name' => 'Tomatoes', 'amount' => 4, 'unit' => 'pieces']);

        // Rejected recipe
        $rejectedRecipe = Recipe::factory()->create([
            'user_id' => $extraUsers[2]->id,
            'title' => 'Simple Scrambled Eggs',
            'description' => 'Just scrambled eggs.',
            'cook_time' => 5,
            'servings' => 1,
            'status' => 'rejected',
            'rejection_reason' => 'Recipe description is too brief and lacks detailed instructions. Please provide more information about cooking techniques and tips.',
        ]);

        Ingredient::create(['recipe_id' => $rejectedRecipe->id, 'name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces']);
        Ingredient::create(['recipe_id' => $rejectedRecipe->id, 'name' => 'Butter', 'amount' => 1, 'unit' => 'tbsp']);

        $this->command->info('✓ Created 9 recipes with ingredients');

        // 3. Add likes and dislikes
        $this->command->info('Adding likes and dislikes...');

        // Pizza gets lots of likes
        Like::create(['user_id' => $jane->id, 'likeable_id' => $approvedRecipe1->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[0]->id, 'likeable_id' => $approvedRecipe1->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[1]->id, 'likeable_id' => $approvedRecipe1->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[2]->id, 'likeable_id' => $approvedRecipe1->id, 'likeable_type' => Recipe::class, 'is_like' => false]); // 1 dislike

        // Thai Curry mixed reception
        Like::create(['user_id' => $user->id, 'likeable_id' => $approvedRecipe2->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[0]->id, 'likeable_id' => $approvedRecipe2->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[1]->id, 'likeable_id' => $approvedRecipe2->id, 'likeable_type' => Recipe::class, 'is_like' => false]);
        Like::create(['user_id' => $extraUsers[2]->id, 'likeable_id' => $approvedRecipe2->id, 'likeable_type' => Recipe::class, 'is_like' => false]);

        // Croissants popular
        Like::create(['user_id' => $user->id, 'likeable_id' => $approvedRecipe3->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $jane->id, 'likeable_id' => $approvedRecipe3->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $extraUsers[1]->id, 'likeable_id' => $approvedRecipe3->id, 'likeable_type' => Recipe::class, 'is_like' => true]);

        // Tacos
        Like::create(['user_id' => $user->id, 'likeable_id' => $approvedRecipe4->id, 'likeable_type' => Recipe::class, 'is_like' => true]);
        Like::create(['user_id' => $jane->id, 'likeable_id' => $approvedRecipe4->id, 'likeable_type' => Recipe::class, 'is_like' => true]);

        $this->command->info('✓ Added likes and dislikes');

        // 4. Add saved recipes (favorites)
        $this->command->info('Adding saved recipes...');

        $user->savedRecipes()->attach($approvedRecipe1->id);
        $user->savedRecipes()->attach($approvedRecipe3->id);

        $jane->savedRecipes()->attach($approvedRecipe1->id);
        $jane->savedRecipes()->attach($approvedRecipe4->id);

        $this->command->info('✓ Added saved recipes');

        // Summary
        $this->command->info('');
        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Test Accounts:');
        $this->command->info('   Admin: admin@getcooked.test / admin123');
        $this->command->info('   User:  user@getcooked.test / user123');
        $this->command->info('   Jane:  jane@getcooked.test / user123');
        $this->command->info('');
        $this->command->info('📊 Database Contents:');
        $this->command->info("   Users: {$allUsers->count()}");
        $this->command->info('   Recipes: ' . Recipe::count() . ' (Private: 2, Pending: 2, Approved: 4, Rejected: 1)');
        $this->command->info('   Ingredients: ' . Ingredient::count());
        $this->command->info('   Likes/Dislikes: ' . Like::count());
        $this->command->info('');
    }
}
