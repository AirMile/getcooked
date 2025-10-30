<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\RecipeStep;
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

        RecipeStep::create(['recipe_id' => $privateRecipe1->id, 'step_number' => 1, 'description' => 'Preheat oven to 180°C (350°F). Grease and line a round cake tin.']);
        RecipeStep::create(['recipe_id' => $privateRecipe1->id, 'step_number' => 2, 'description' => 'Melt the dark chocolate in a double boiler or microwave. Set aside to cool slightly.']);
        RecipeStep::create(['recipe_id' => $privateRecipe1->id, 'step_number' => 3, 'description' => 'In a large bowl, cream together the sugar and eggs until light and fluffy.']);
        RecipeStep::create(['recipe_id' => $privateRecipe1->id, 'step_number' => 4, 'description' => 'Fold in the melted chocolate and sifted flour gently until just combined.']);
        RecipeStep::create(['recipe_id' => $privateRecipe1->id, 'step_number' => 5, 'description' => 'Pour batter into prepared tin and bake for 35-45 minutes until a skewer comes out clean.']);

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

        RecipeStep::create(['recipe_id' => $privateRecipe2->id, 'step_number' => 1, 'description' => 'Add banana, spinach, and almond milk to a blender.']);
        RecipeStep::create(['recipe_id' => $privateRecipe2->id, 'step_number' => 2, 'description' => 'Blend on high speed for 30-60 seconds until smooth and creamy.']);
        RecipeStep::create(['recipe_id' => $privateRecipe2->id, 'step_number' => 3, 'description' => 'Pour into a glass and enjoy immediately!']);

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

        RecipeStep::create(['recipe_id' => $pendingRecipe1->id, 'step_number' => 1, 'description' => 'Bring a large pot of salted water to boil and cook spaghetti according to package directions until al dente.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe1->id, 'step_number' => 2, 'description' => 'While pasta cooks, dice guanciale and render it in a pan over medium heat until crispy.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe1->id, 'step_number' => 3, 'description' => 'Beat eggs with grated pecorino in a bowl to create a smooth mixture.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe1->id, 'step_number' => 4, 'description' => 'Drain pasta, reserving 1 cup of pasta water. Add pasta to the pan with guanciale off heat.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe1->id, 'step_number' => 5, 'description' => 'Quickly stir in egg mixture, adding pasta water as needed to create a creamy sauce. Serve immediately.']);

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

        RecipeStep::create(['recipe_id' => $pendingRecipe2->id, 'step_number' => 1, 'description' => 'Preheat oven to 200°C (400°F). Dice sweet potato and roast for 25-30 minutes until tender.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe2->id, 'step_number' => 2, 'description' => 'Cook quinoa according to package instructions. Drain and set aside.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe2->id, 'step_number' => 3, 'description' => 'Drain and rinse chickpeas. Season with spices of choice and roast for 15-20 minutes.']);
        RecipeStep::create(['recipe_id' => $pendingRecipe2->id, 'step_number' => 4, 'description' => 'Assemble bowl with quinoa, roasted sweet potato, chickpeas, and your favorite fresh vegetables. Drizzle with tahini dressing.']);

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

        RecipeStep::create(['recipe_id' => $approvedRecipe1->id, 'step_number' => 1, 'description' => 'Mix flour, water, yeast, and salt in a large bowl. Knead for 10 minutes until smooth and elastic.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe1->id, 'step_number' => 2, 'description' => 'Cover dough and let it rise at room temperature for 6-8 hours, or until doubled in size.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe1->id, 'step_number' => 3, 'description' => 'Divide dough into 4 balls. Let rest for 30 minutes before stretching.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe1->id, 'step_number' => 4, 'description' => 'Preheat oven to maximum temperature (250°C+) with pizza stone inside.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe1->id, 'step_number' => 5, 'description' => 'Stretch dough, add sauce and toppings. Bake for 8-10 minutes until crust is golden and cheese is bubbling.']);

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

        RecipeStep::create(['recipe_id' => $approvedRecipe2->id, 'step_number' => 1, 'description' => 'Cut chicken breast into bite-sized pieces. Prep your choice of vegetables (bell peppers, bamboo shoots, thai basil).']);
        RecipeStep::create(['recipe_id' => $approvedRecipe2->id, 'step_number' => 2, 'description' => 'Heat oil in a wok or large pan over medium-high heat. Fry green curry paste for 1-2 minutes until fragrant.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe2->id, 'step_number' => 3, 'description' => 'Add chicken and stir-fry until lightly browned. Pour in coconut milk and bring to a simmer.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe2->id, 'step_number' => 4, 'description' => 'Add vegetables and simmer for 10-15 minutes until chicken is cooked through and vegetables are tender.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe2->id, 'step_number' => 5, 'description' => 'Season with fish sauce and palm sugar to taste. Serve hot with jasmine rice and fresh thai basil.']);

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

        RecipeStep::create(['recipe_id' => $approvedRecipe3->id, 'step_number' => 1, 'description' => 'Mix flour, milk, sugar, salt, and yeast. Knead until smooth dough forms. Refrigerate overnight.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe3->id, 'step_number' => 2, 'description' => 'Roll out cold dough into a rectangle. Place butter block in center and fold dough over it.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe3->id, 'step_number' => 3, 'description' => 'Perform 3 sets of rolling and folding (letter folds), chilling 30 minutes between each set.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe3->id, 'step_number' => 4, 'description' => 'Roll dough to 5mm thickness, cut into triangles, and roll each into a croissant shape. Proof for 2 hours.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe3->id, 'step_number' => 5, 'description' => 'Brush with egg wash and bake at 200°C (400°F) for 15-18 minutes until golden brown and flaky.']);

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

        RecipeStep::create(['recipe_id' => $approvedRecipe4->id, 'step_number' => 1, 'description' => 'Brown ground beef in a large skillet over medium-high heat, breaking it up as it cooks.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe4->id, 'step_number' => 2, 'description' => 'Drain excess fat, then stir in taco seasoning and water according to package directions. Simmer for 5 minutes.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe4->id, 'step_number' => 3, 'description' => 'While beef cooks, dice tomatoes, onions, and cilantro for fresh salsa. Mix with lime juice and salt.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe4->id, 'step_number' => 4, 'description' => 'Warm tortillas in a dry pan or directly over gas flame until soft and lightly charred.']);
        RecipeStep::create(['recipe_id' => $approvedRecipe4->id, 'step_number' => 5, 'description' => 'Assemble tacos with seasoned beef, fresh salsa, and your favorite toppings (cheese, sour cream, lettuce).']);

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

        RecipeStep::create(['recipe_id' => $rejectedRecipe->id, 'step_number' => 1, 'description' => 'Crack eggs into a bowl and whisk.']);
        RecipeStep::create(['recipe_id' => $rejectedRecipe->id, 'step_number' => 2, 'description' => 'Melt butter in pan and add eggs. Stir until cooked.']);

        $this->command->info('✓ Created 9 recipes with ingredients and steps');

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
