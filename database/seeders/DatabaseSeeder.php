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

        $privateUser = User::factory()->create([
            'name' => 'Private Cook',
            'email' => 'private@getcooked.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create 12 regular users
        $users = [];
        for ($i = 1; $i <= 12; $i++) {
            $users[] = User::factory()->create([
                'name' => "User {$i}",
                'email' => "user{$i}@getcooked.test",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        $allUsers = collect([$admin, $privateUser])->merge($users);
        $this->command->info("✓ Created {$allUsers->count()} users");

        // 2. Create recipes
        $this->command->info('Creating recipes...');

        $recipes = [];

        // ============================================
        // PRIVATE RECIPES (5) - for privateUser only
        // ============================================

        $recipes[] = $this->createRecipe($privateUser, [
            'title' => 'My Secret Chocolate Cake',
            'description' => 'A family recipe passed down for generations. Rich, moist, and absolutely delicious!',
            'cook_time' => 45,
            'servings' => 8,
            'difficulty' => 'medium',
            'cuisine' => 'American',
            'category' => 'Dessert',
            'status' => 'private',
            'photo_path' => null,
            'ingredients' => [
                ['name' => 'Dark Chocolate', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Flour', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Sugar', 'amount' => 250, 'unit' => 'g'],
                ['name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces'],
            ],
            'steps' => [
                'Preheat oven to 180°C (350°F). Grease and line a round cake tin.',
                'Melt the dark chocolate in a double boiler. Set aside to cool slightly.',
                'Cream together sugar and eggs until light and fluffy.',
                'Fold in melted chocolate and sifted flour until just combined.',
                'Bake for 35-45 minutes until a skewer comes out clean.',
            ],
        ]);

        $recipes[] = $this->createRecipe($privateUser, [
            'title' => 'Grandma\'s Apple Pie',
            'description' => 'Traditional apple pie with a secret spice blend that makes it special.',
            'cook_time' => 90,
            'servings' => 8,
            'difficulty' => 'medium',
            'cuisine' => 'American',
            'category' => 'Dessert',
            'status' => 'private',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Apples', 'amount' => 6, 'unit' => 'pieces'],
                ['name' => 'Pie Crust', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Sugar', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Cinnamon', 'amount' => 2, 'unit' => 'tsp'],
            ],
            'steps' => [
                'Peel and slice apples. Mix with sugar, cinnamon, and secret spices.',
                'Line pie dish with bottom crust and fill with apple mixture.',
                'Cover with top crust, seal edges, and cut vents.',
                'Bake at 190°C for 50-60 minutes until golden brown.',
            ],
        ]);

        $recipes[] = $this->createRecipe($privateUser, [
            'title' => 'Personal Protein Smoothie',
            'description' => 'My daily breakfast smoothie with the perfect macros.',
            'cook_time' => 5,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Breakfast',
            'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
            'status' => 'private',
            'photo_path' => null,
            'ingredients' => [
                ['name' => 'Banana', 'amount' => 1, 'unit' => 'piece'],
                ['name' => 'Protein Powder', 'amount' => 30, 'unit' => 'g'],
                ['name' => 'Almond Milk', 'amount' => 250, 'unit' => 'ml'],
            ],
            'steps' => [
                'Add all ingredients to a blender.',
                'Blend on high for 30 seconds until smooth.',
                'Enjoy immediately!',
            ],
        ]);

        $recipes[] = $this->createRecipe($privateUser, [
            'title' => 'Quick Garlic Noodles',
            'description' => 'My go-to lazy dinner. Ready in 10 minutes!',
            'cook_time' => 10,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'Asian',
            'category' => 'Dinner',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'private',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Noodles', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Garlic', 'amount' => 4, 'unit' => 'cloves'],
                ['name' => 'Soy Sauce', 'amount' => 2, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Cook noodles according to package instructions.',
                'Sauté minced garlic in oil until fragrant.',
                'Toss noodles with garlic and soy sauce. Serve hot.',
            ],
        ]);

        $recipes[] = $this->createRecipe($privateUser, [
            'title' => 'Meal Prep Chicken Bowl',
            'description' => 'My weekly meal prep recipe. Makes 5 servings.',
            'cook_time' => 40,
            'servings' => 5,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Lunch',
            'dietary_tags' => json_encode(['gluten-free']),
            'status' => 'private',
            'photo_path' => null,
            'ingredients' => [
                ['name' => 'Chicken Breast', 'amount' => 750, 'unit' => 'g'],
                ['name' => 'Rice', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Broccoli', 'amount' => 500, 'unit' => 'g'],
            ],
            'steps' => [
                'Season and bake chicken at 200°C for 25 minutes.',
                'Cook rice according to package instructions.',
                'Steam broccoli for 5 minutes.',
                'Divide into 5 containers for the week.',
            ],
        ]);

        // ============================================
        // APPROVED RECIPES (20) - Public and visible
        // ============================================

        $recipes[] = $this->createRecipe($users[0], [
            'title' => 'Emily Mariko Salmon Rice Bowl',
            'description' => 'The viral TikTok recipe! Leftover salmon and rice transformed into an amazing bowl with kewpie mayo, soy sauce, and kimchi.',
            'cook_time' => 15,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'Japanese',
            'category' => 'Lunch',
            'dietary_tags' => json_encode(['gluten-free']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Leftover Salmon', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Cooked Rice', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Kewpie Mayo', 'amount' => 2, 'unit' => 'tbsp'],
                ['name' => 'Soy Sauce', 'amount' => 1, 'unit' => 'tbsp'],
                ['name' => 'Kimchi', 'amount' => 50, 'unit' => 'g'],
                ['name' => 'Avocado', 'amount' => 0.5, 'unit' => 'piece'],
            ],
            'steps' => [
                'Place salmon and rice in a microwave-safe bowl.',
                'Cover with parchment paper and microwave for 1.5 minutes.',
                'Break up salmon and mix with rice, kewpie mayo, and soy sauce.',
                'Top with kimchi, sliced avocado, and seaweed snacks.',
                'Enjoy this viral sensation!',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[1], [
            'title' => 'Gigi Hadid Vodka Pasta',
            'description' => 'The famous Instagram recipe! Creamy, spicy tomato vodka sauce that went viral.',
            'cook_time' => 30,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Italian',
            'category' => 'Dinner',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Pasta', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Tomato Paste', 'amount' => 100, 'unit' => 'g'],
                ['name' => 'Heavy Cream', 'amount' => 200, 'unit' => 'ml'],
                ['name' => 'Vodka', 'amount' => 60, 'unit' => 'ml'],
                ['name' => 'Garlic', 'amount' => 3, 'unit' => 'cloves'],
            ],
            'steps' => [
                'Cook pasta according to package instructions.',
                'Sauté minced garlic and red pepper flakes in olive oil.',
                'Add tomato paste and cook for 3-4 minutes.',
                'Pour in vodka and let it cook off for 2 minutes.',
                'Stir in heavy cream, simmer, then toss with pasta.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[2], [
            'title' => 'Fluffy Buttermilk Pancakes',
            'description' => 'The fluffiest pancakes you\'ll ever make! Perfect for weekend brunch.',
            'cook_time' => 20,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Breakfast',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Flour', 'amount' => 250, 'unit' => 'g'],
                ['name' => 'Buttermilk', 'amount' => 300, 'unit' => 'ml'],
                ['name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Baking Powder', 'amount' => 2, 'unit' => 'tsp'],
            ],
            'steps' => [
                'Mix flour, baking powder, and a pinch of salt in a bowl.',
                'Whisk together buttermilk and eggs in another bowl.',
                'Combine wet and dry ingredients until just mixed (lumps are okay!).',
                'Cook on a hot griddle for 2-3 minutes per side until golden.',
                'Serve with maple syrup and fresh berries.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[3], [
            'title' => 'Pad Thai',
            'description' => 'Authentic Thai street food classic with rice noodles, shrimp, and tamarind sauce.',
            'cook_time' => 25,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Thai',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Rice Noodles', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Shrimp', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Tamarind Paste', 'amount' => 3, 'unit' => 'tbsp'],
                ['name' => 'Fish Sauce', 'amount' => 2, 'unit' => 'tbsp'],
                ['name' => 'Peanuts', 'amount' => 50, 'unit' => 'g'],
            ],
            'steps' => [
                'Soak rice noodles in warm water for 15 minutes, then drain.',
                'Make sauce by mixing tamarind paste, fish sauce, and palm sugar.',
                'Stir-fry shrimp in hot wok until pink, then remove.',
                'Scramble eggs in the wok, add noodles and sauce, toss well.',
                'Add shrimp back, top with peanuts, bean sprouts, and lime wedge.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[4], [
            'title' => 'Chicken Katsu',
            'description' => 'Crispy Japanese fried chicken cutlet with tonkatsu sauce. Absolutely delicious!',
            'cook_time' => 30,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Japanese',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Chicken Breast', 'amount' => 600, 'unit' => 'g'],
                ['name' => 'Panko Breadcrumbs', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Flour', 'amount' => 100, 'unit' => 'g'],
            ],
            'steps' => [
                'Pound chicken breasts to even thickness, about 1.5cm.',
                'Set up breading station: flour, beaten eggs, panko.',
                'Coat each chicken piece in flour, egg, then panko.',
                'Deep fry at 180°C for 5-6 minutes until golden and cooked through.',
                'Slice and serve with shredded cabbage and tonkatsu sauce.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[5], [
            'title' => 'Beef Tacos with Fresh Salsa',
            'description' => 'Delicious street-style tacos with seasoned beef and homemade pico de gallo.',
            'cook_time' => 25,
            'servings' => 6,
            'difficulty' => 'easy',
            'cuisine' => 'Mexican',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Ground Beef', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Taco Seasoning', 'amount' => 2, 'unit' => 'tbsp'],
                ['name' => 'Corn Tortillas', 'amount' => 12, 'unit' => 'pieces'],
                ['name' => 'Tomatoes', 'amount' => 3, 'unit' => 'pieces'],
                ['name' => 'Cilantro', 'amount' => 30, 'unit' => 'g'],
            ],
            'steps' => [
                'Brown ground beef, breaking it up as it cooks. Drain fat.',
                'Add taco seasoning and water, simmer for 5 minutes.',
                'Dice tomatoes, onions, cilantro for salsa. Add lime juice.',
                'Warm tortillas over open flame until lightly charred.',
                'Assemble tacos with beef, salsa, and your favorite toppings.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[6], [
            'title' => 'Classic Greek Salad',
            'description' => 'Authentic Horiatiki with fresh vegetables, feta cheese, and kalamata olives.',
            'cook_time' => 15,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'Greek',
            'category' => 'Salad',
            'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Tomatoes', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Cucumber', 'amount' => 1, 'unit' => 'piece'],
                ['name' => 'Feta Cheese', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Kalamata Olives', 'amount' => 100, 'unit' => 'g'],
                ['name' => 'Olive Oil', 'amount' => 4, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Cut tomatoes and cucumber into large chunks.',
                'Slice red onion and bell pepper.',
                'Combine vegetables in a bowl with kalamata olives.',
                'Top with a thick slice of feta cheese.',
                'Dress with olive oil, oregano, and a splash of red wine vinegar.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[7], [
            'title' => 'Vegan Buddha Bowl',
            'description' => 'Colorful and nutritious plant-based bowl with quinoa, roasted chickpeas, and tahini dressing.',
            'cook_time' => 35,
            'servings' => 2,
            'difficulty' => 'easy',
            'cuisine' => 'Mediterranean',
            'category' => 'Lunch',
            'dietary_tags' => json_encode(['vegan', 'gluten-free']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Quinoa', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Chickpeas', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Sweet Potato', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Tahini', 'amount' => 3, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Roast diced sweet potato at 200°C for 25 minutes.',
                'Toss chickpeas with spices and roast for 20 minutes.',
                'Cook quinoa according to package instructions.',
                'Make tahini dressing with tahini, lemon juice, and water.',
                'Assemble bowls with quinoa, sweet potato, chickpeas, and fresh veggies.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[8], [
            'title' => 'Fudgy Chocolate Brownies',
            'description' => 'Rich, fudgy brownies with a crispy top and gooey center. Chocolate lover\'s dream!',
            'cook_time' => 35,
            'servings' => 12,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Dessert',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Dark Chocolate', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Butter', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Sugar', 'amount' => 250, 'unit' => 'g'],
                ['name' => 'Eggs', 'amount' => 3, 'unit' => 'pieces'],
                ['name' => 'Flour', 'amount' => 100, 'unit' => 'g'],
            ],
            'steps' => [
                'Preheat oven to 180°C. Line a square baking pan with parchment.',
                'Melt chocolate and butter together. Let cool slightly.',
                'Whisk in sugar and eggs until smooth and glossy.',
                'Fold in flour and cocoa powder until just combined.',
                'Bake for 25-30 minutes. Cool before cutting into squares.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[9], [
            'title' => 'Korean Bibimbap',
            'description' => 'Traditional Korean rice bowl with vegetables, beef, and gochujang sauce.',
            'cook_time' => 40,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Korean',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Rice', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Beef', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Spinach', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Carrots', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Gochujang', 'amount' => 3, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Cook rice and keep warm.',
                'Marinate sliced beef in soy sauce, sesame oil, and garlic.',
                'Blanch spinach and sauté julienned carrots separately.',
                'Cook beef until browned.',
                'Serve rice in bowls topped with vegetables, beef, fried egg, and gochujang.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[10], [
            'title' => 'Chicken Enchiladas',
            'description' => 'Cheesy chicken enchiladas with red sauce. Comfort food at its finest!',
            'cook_time' => 45,
            'servings' => 6,
            'difficulty' => 'medium',
            'cuisine' => 'Mexican',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Chicken Breast', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Tortillas', 'amount' => 8, 'unit' => 'pieces'],
                ['name' => 'Enchilada Sauce', 'amount' => 400, 'unit' => 'ml'],
                ['name' => 'Cheese', 'amount' => 300, 'unit' => 'g'],
            ],
            'steps' => [
                'Cook and shred chicken. Mix with some cheese and seasonings.',
                'Warm tortillas to make them pliable.',
                'Fill each tortilla with chicken mixture and roll up.',
                'Place seam-side down in baking dish, cover with sauce and cheese.',
                'Bake at 180°C for 25 minutes until bubbly and golden.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[11], [
            'title' => 'Spanish Paella',
            'description' => 'Traditional Valencian paella with chicken, seafood, and saffron rice.',
            'cook_time' => 60,
            'servings' => 6,
            'difficulty' => 'hard',
            'cuisine' => 'Spanish',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Paella Rice', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Chicken Thighs', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Shrimp', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Saffron', 'amount' => 1, 'unit' => 'pinch'],
                ['name' => 'Bell Peppers', 'amount' => 2, 'unit' => 'pieces'],
            ],
            'steps' => [
                'Brown chicken pieces in paella pan with olive oil.',
                'Add diced peppers and cook until soft.',
                'Stir in rice, saffron, and paprika. Toast for 2 minutes.',
                'Pour in hot stock and arrange shrimp on top.',
                'Simmer without stirring for 20-25 minutes until rice is tender.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[0], [
            'title' => 'Baked Feta Pasta',
            'description' => 'The viral TikTok recipe! Baked feta with cherry tomatoes creates a creamy sauce.',
            'cook_time' => 35,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'Greek',
            'category' => 'Dinner',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Feta Cheese', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Cherry Tomatoes', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Pasta', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Olive Oil', 'amount' => 60, 'unit' => 'ml'],
                ['name' => 'Garlic', 'amount' => 4, 'unit' => 'cloves'],
            ],
            'steps' => [
                'Place feta block in center of baking dish, surround with cherry tomatoes.',
                'Drizzle everything with olive oil, add garlic cloves.',
                'Bake at 200°C for 30 minutes until tomatoes burst.',
                'Meanwhile, cook pasta according to package instructions.',
                'Mash feta and tomatoes together, toss with pasta and fresh basil.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[1], [
            'title' => 'Thai Green Curry',
            'description' => 'Aromatic Thai curry with coconut milk, chicken, and vegetables.',
            'cook_time' => 40,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Thai',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Green Curry Paste', 'amount' => 3, 'unit' => 'tbsp'],
                ['name' => 'Coconut Milk', 'amount' => 400, 'unit' => 'ml'],
                ['name' => 'Chicken Breast', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Thai Basil', 'amount' => 30, 'unit' => 'g'],
            ],
            'steps' => [
                'Fry curry paste in oil until fragrant, about 2 minutes.',
                'Add diced chicken and cook until lightly browned.',
                'Pour in coconut milk and bring to a simmer.',
                'Add vegetables and cook for 10-15 minutes.',
                'Finish with fish sauce, palm sugar, and fresh Thai basil.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[2], [
            'title' => 'Belgian Waffles',
            'description' => 'Crispy on the outside, fluffy on the inside. Perfect breakfast treat!',
            'cook_time' => 25,
            'servings' => 6,
            'difficulty' => 'easy',
            'cuisine' => 'Belgian',
            'category' => 'Breakfast',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Flour', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Milk', 'amount' => 400, 'unit' => 'ml'],
                ['name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Butter', 'amount' => 80, 'unit' => 'g'],
            ],
            'steps' => [
                'Separate eggs. Mix yolks with milk and melted butter.',
                'Combine with flour and baking powder.',
                'Beat egg whites to stiff peaks and fold into batter.',
                'Cook in preheated waffle iron for 3-4 minutes until golden.',
                'Serve with berries, whipped cream, and maple syrup.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[3], [
            'title' => 'Kung Pao Chicken',
            'description' => 'Spicy Sichuan stir-fry with peanuts and dried chilies.',
            'cook_time' => 25,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Chinese',
            'category' => 'Dinner',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Chicken Breast', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Peanuts', 'amount' => 100, 'unit' => 'g'],
                ['name' => 'Dried Chilies', 'amount' => 10, 'unit' => 'pieces'],
                ['name' => 'Soy Sauce', 'amount' => 3, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Cut chicken into cubes and marinate in soy sauce.',
                'Stir-fry dried chilies and Sichuan peppercorns until fragrant.',
                'Add chicken and cook until browned.',
                'Toss in sauce (soy, vinegar, sugar) and peanuts.',
                'Serve over rice, garnished with green onions.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[4], [
            'title' => 'Tiramisu',
            'description' => 'Classic Italian dessert with coffee-soaked ladyfingers and mascarpone cream.',
            'cook_time' => 30,
            'servings' => 8,
            'difficulty' => 'medium',
            'cuisine' => 'Italian',
            'category' => 'Dessert',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Mascarpone', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Ladyfinger Cookies', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Espresso', 'amount' => 300, 'unit' => 'ml'],
                ['name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Cocoa Powder', 'amount' => 3, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Whip egg yolks with sugar until pale and fluffy.',
                'Fold in mascarpone cheese until smooth.',
                'Dip ladyfingers in cooled espresso and layer in dish.',
                'Spread half the mascarpone mixture over ladyfingers.',
                'Repeat layers, dust with cocoa, and refrigerate for 4 hours.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[5], [
            'title' => 'Eggs Benedict',
            'description' => 'Classic brunch dish with poached eggs, Canadian bacon, and hollandaise sauce.',
            'cook_time' => 30,
            'servings' => 4,
            'difficulty' => 'hard',
            'cuisine' => 'American',
            'category' => 'Breakfast',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Eggs', 'amount' => 8, 'unit' => 'pieces'],
                ['name' => 'English Muffins', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Canadian Bacon', 'amount' => 8, 'unit' => 'slices'],
                ['name' => 'Butter', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Lemon Juice', 'amount' => 2, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Make hollandaise: blend egg yolks with lemon juice, slowly add melted butter.',
                'Poach eggs in simmering water with vinegar for 3-4 minutes.',
                'Toast English muffins and cook Canadian bacon.',
                'Assemble: muffin, bacon, poached egg, hollandaise sauce.',
                'Garnish with fresh chives and serve immediately.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[6], [
            'title' => 'Loaded Nachos',
            'description' => 'Ultimate nachos with all the toppings! Perfect for game day.',
            'cook_time' => 20,
            'servings' => 6,
            'difficulty' => 'easy',
            'cuisine' => 'Mexican',
            'category' => 'Snack',
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Tortilla Chips', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Cheese', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Ground Beef', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Sour Cream', 'amount' => 150, 'unit' => 'ml'],
                ['name' => 'Jalapeños', 'amount' => 50, 'unit' => 'g'],
            ],
            'steps' => [
                'Brown ground beef with taco seasoning.',
                'Layer tortilla chips on a large baking sheet.',
                'Top with beef, cheese, black beans, and jalapeños.',
                'Bake at 180°C for 10 minutes until cheese melts.',
                'Top with sour cream, guacamole, and fresh cilantro.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[7], [
            'title' => 'Matcha Green Tea Cake',
            'description' => 'Beautiful Japanese-inspired cake with earthy matcha flavor.',
            'cook_time' => 60,
            'servings' => 8,
            'difficulty' => 'medium',
            'cuisine' => 'Japanese',
            'category' => 'Dessert',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'approved',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Flour', 'amount' => 250, 'unit' => 'g'],
                ['name' => 'Matcha Powder', 'amount' => 3, 'unit' => 'tbsp'],
                ['name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Sugar', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Butter', 'amount' => 120, 'unit' => 'g'],
            ],
            'steps' => [
                'Preheat oven to 180°C. Grease and line a cake pan.',
                'Sift together flour, matcha powder, and baking powder.',
                'Cream butter and sugar, then beat in eggs one at a time.',
                'Fold in dry ingredients until just combined.',
                'Bake for 40-45 minutes. Cool and dust with matcha powder.',
            ],
        ]);

        // ============================================
        // PENDING RECIPES (7) - Waiting for approval
        // ============================================

        $recipes[] = $this->createRecipe($users[8], [
            'title' => 'Classic Carbonara',
            'description' => 'Authentic Italian carbonara with guanciale, eggs, and pecorino.',
            'cook_time' => 25,
            'servings' => 4,
            'difficulty' => 'medium',
            'cuisine' => 'Italian',
            'category' => 'Dinner',
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Spaghetti', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Guanciale', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Pecorino Romano', 'amount' => 100, 'unit' => 'g'],
            ],
            'steps' => [
                'Cook spaghetti in salted boiling water until al dente.',
                'Dice and render guanciale until crispy.',
                'Mix egg yolks with grated pecorino.',
                'Toss hot pasta with guanciale off heat, then add egg mixture.',
                'Use pasta water to create creamy sauce. Serve immediately.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[9], [
            'title' => 'Birria Tacos',
            'description' => 'Trendy TikTok tacos! Slow-cooked beef in red chili sauce, served with consommé.',
            'cook_time' => 180,
            'servings' => 8,
            'difficulty' => 'hard',
            'cuisine' => 'Mexican',
            'category' => 'Dinner',
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Beef Chuck', 'amount' => 1500, 'unit' => 'g'],
                ['name' => 'Dried Chilies', 'amount' => 8, 'unit' => 'pieces'],
                ['name' => 'Corn Tortillas', 'amount' => 16, 'unit' => 'pieces'],
                ['name' => 'Cheese', 'amount' => 300, 'unit' => 'g'],
            ],
            'steps' => [
                'Toast and rehydrate dried chilies, blend into sauce with spices.',
                'Marinate beef in chili sauce, braise for 3 hours until tender.',
                'Shred beef and strain consommé (broth).',
                'Dip tortillas in consommé, fill with beef and cheese, fry until crispy.',
                'Serve with consommé for dipping!',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[10], [
            'title' => 'Shrimp Fried Rice',
            'description' => 'Better than takeout! Quick and flavorful fried rice with shrimp.',
            'cook_time' => 20,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'Chinese',
            'category' => 'Dinner',
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Cooked Rice', 'amount' => 600, 'unit' => 'g'],
                ['name' => 'Shrimp', 'amount' => 300, 'unit' => 'g'],
                ['name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Soy Sauce', 'amount' => 3, 'unit' => 'tbsp'],
                ['name' => 'Mixed Vegetables', 'amount' => 200, 'unit' => 'g'],
            ],
            'steps' => [
                'Heat wok over high heat with oil.',
                'Scramble eggs and remove. Cook shrimp until pink, remove.',
                'Stir-fry vegetables, add cold rice and break up clumps.',
                'Add soy sauce, sesame oil, return eggs and shrimp.',
                'Toss everything together and garnish with green onions.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[11], [
            'title' => 'French Toast with Berries',
            'description' => 'Custardy French toast with fresh berries and maple syrup.',
            'cook_time' => 20,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'French',
            'category' => 'Breakfast',
            'dietary_tags' => json_encode(['vegetarian']),
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Bread', 'amount' => 8, 'unit' => 'slices'],
                ['name' => 'Eggs', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Milk', 'amount' => 200, 'unit' => 'ml'],
                ['name' => 'Mixed Berries', 'amount' => 300, 'unit' => 'g'],
            ],
            'steps' => [
                'Whisk together eggs, milk, cinnamon, and vanilla.',
                'Dip bread slices in egg mixture, coating both sides.',
                'Cook on buttered griddle until golden on both sides.',
                'Stack slices and top with fresh berries.',
                'Drizzle with maple syrup and dust with powdered sugar.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[0], [
            'title' => 'Caprese Salad',
            'description' => 'Simple Italian salad with fresh mozzarella, tomatoes, and basil.',
            'cook_time' => 10,
            'servings' => 4,
            'difficulty' => 'easy',
            'cuisine' => 'Italian',
            'category' => 'Salad',
            'dietary_tags' => json_encode(['vegetarian', 'gluten-free']),
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Fresh Mozzarella', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Tomatoes', 'amount' => 4, 'unit' => 'pieces'],
                ['name' => 'Fresh Basil', 'amount' => 30, 'unit' => 'g'],
                ['name' => 'Balsamic Glaze', 'amount' => 3, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Slice tomatoes and mozzarella into rounds.',
                'Arrange alternating slices on a platter.',
                'Tuck fresh basil leaves between slices.',
                'Drizzle with olive oil and balsamic glaze.',
                'Season with sea salt and cracked black pepper.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[1], [
            'title' => 'Mediterranean Chickpea Bowl',
            'description' => 'Healthy grain bowl with roasted chickpeas, hummus, and fresh vegetables.',
            'cook_time' => 30,
            'servings' => 2,
            'difficulty' => 'easy',
            'cuisine' => 'Mediterranean',
            'category' => 'Lunch',
            'dietary_tags' => json_encode(['vegan', 'gluten-free']),
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Chickpeas', 'amount' => 400, 'unit' => 'g'],
                ['name' => 'Quinoa', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Hummus', 'amount' => 150, 'unit' => 'g'],
                ['name' => 'Cucumber', 'amount' => 1, 'unit' => 'piece'],
            ],
            'steps' => [
                'Roast chickpeas with paprika and cumin at 200°C for 25 minutes.',
                'Cook quinoa according to package instructions.',
                'Dice cucumber and tomatoes.',
                'Assemble bowls with quinoa, roasted chickpeas, vegetables.',
                'Top with hummus, olives, and lemon-tahini dressing.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[2], [
            'title' => 'Chicken Dumplings',
            'description' => 'Homemade Chinese dumplings with juicy chicken filling.',
            'cook_time' => 60,
            'servings' => 6,
            'difficulty' => 'hard',
            'cuisine' => 'Chinese',
            'category' => 'Appetizer',
            'status' => 'pending',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Ground Chicken', 'amount' => 500, 'unit' => 'g'],
                ['name' => 'Dumpling Wrappers', 'amount' => 50, 'unit' => 'pieces'],
                ['name' => 'Cabbage', 'amount' => 200, 'unit' => 'g'],
                ['name' => 'Ginger', 'amount' => 20, 'unit' => 'g'],
            ],
            'steps' => [
                'Mix ground chicken with finely chopped cabbage, ginger, and seasonings.',
                'Place spoonful of filling in center of wrapper.',
                'Fold and pleat edges to seal dumpling.',
                'Steam for 8-10 minutes or pan-fry until golden.',
                'Serve with soy-vinegar dipping sauce.',
            ],
        ]);

        // ============================================
        // REJECTED RECIPES (3) - Declined by admin
        // ============================================

        $recipes[] = $this->createRecipe($users[3], [
            'title' => 'Scrambled Eggs',
            'description' => 'Just eggs.',
            'cook_time' => 5,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Breakfast',
            'status' => 'rejected',
            'rejection_reason' => 'Recipe description is too brief and lacks detailed instructions. Please provide more information about cooking techniques and tips.',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Eggs', 'amount' => 2, 'unit' => 'pieces'],
                ['name' => 'Butter', 'amount' => 1, 'unit' => 'tbsp'],
            ],
            'steps' => [
                'Crack eggs into bowl.',
                'Cook in pan with butter.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[4], [
            'title' => 'Microwave Pizza',
            'description' => 'Pizza in microwave.',
            'cook_time' => 3,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'American',
            'category' => 'Snack',
            'status' => 'rejected',
            'rejection_reason' => 'This recipe does not meet quality standards. Microwave pizza is not suitable for our platform focused on proper cooking techniques.',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Frozen Pizza', 'amount' => 1, 'unit' => 'piece'],
            ],
            'steps' => [
                'Remove pizza from box.',
                'Microwave for 3 minutes.',
            ],
        ]);

        $recipes[] = $this->createRecipe($users[5], [
            'title' => 'Boiled Water',
            'description' => 'Water that is boiled.',
            'cook_time' => 5,
            'servings' => 1,
            'difficulty' => 'easy',
            'cuisine' => 'International',
            'category' => 'Other',
            'status' => 'rejected',
            'rejection_reason' => 'This is not a recipe. Please submit actual cooking recipes with meaningful ingredients and preparation steps.',
            'photo_path' => fake()->imageUrl(640, 480, 'food', true),
            'ingredients' => [
                ['name' => 'Water', 'amount' => 500, 'unit' => 'ml'],
            ],
            'steps' => [
                'Put water in pot.',
                'Turn on heat.',
                'Wait until it boils.',
            ],
        ]);

        $this->command->info("✓ Created " . count($recipes) . " recipes");

        // 3. Add likes and dislikes
        $this->command->info('Adding likes and dislikes...');

        $approvedRecipes = collect($recipes)->where('status', 'approved');
        $likeCount = 0;

        // Viral recipes get lots of likes (Emily Mariko, Gigi Hadid, Baked Feta)
        foreach ($approvedRecipes->take(3) as $recipe) {
            $shuffledUsers = collect($users)->shuffle()->take(8);
            foreach ($shuffledUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $recipe->id,
                    'likeable_type' => Recipe::class,
                    'is_like' => rand(1, 10) > 2, // 80% likes
                ]);
                $likeCount++;
            }
        }

        // Other recipes get moderate likes
        foreach ($approvedRecipes->skip(3) as $recipe) {
            $numLikes = rand(3, 6);
            $shuffledUsers = collect($users)->shuffle()->take($numLikes);
            foreach ($shuffledUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $recipe->id,
                    'likeable_type' => Recipe::class,
                    'is_like' => rand(1, 10) > 3, // 70% likes
                ]);
                $likeCount++;
            }
        }

        $this->command->info("✓ Added {$likeCount} likes and dislikes");

        // 4. Add saved recipes (favorites)
        $this->command->info('Adding saved recipes...');

        $saveCount = 0;
        foreach ($users as $user) {
            // Each user saves 2-4 random approved recipes
            $numSaves = rand(2, 4);
            $recipesToSave = $approvedRecipes->random(min($numSaves, $approvedRecipes->count()));

            foreach ($recipesToSave as $recipe) {
                $user->savedRecipes()->attach($recipe->id);
                $saveCount++;
            }
        }

        $this->command->info("✓ Added {$saveCount} saved recipes");

        // Summary
        $this->command->info('');
        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Test Accounts:');
        $this->command->info('   Admin:   admin@getcooked.test / admin123');
        $this->command->info('   Private: private@getcooked.test / password');
        $this->command->info('   Users:   user1@getcooked.test through user12@getcooked.test / password');
        $this->command->info('');
        $this->command->info('📊 Database Contents:');
        $this->command->info("   Total Users: {$allUsers->count()} (1 admin, 1 private user, 12 regular users)");
        $this->command->info('   Total Recipes: ' . Recipe::count());
        $this->command->info('   - Private: ' . Recipe::where('status', 'private')->count());
        $this->command->info('   - Pending: ' . Recipe::where('status', 'pending')->count());
        $this->command->info('   - Approved: ' . Recipe::where('status', 'approved')->count());
        $this->command->info('   - Rejected: ' . Recipe::where('status', 'rejected')->count());
        $this->command->info('   Total Ingredients: ' . Ingredient::count());
        $this->command->info('   Total Recipe Steps: ' . RecipeStep::count());
        $this->command->info('   Total Likes/Dislikes: ' . Like::count());
        $this->command->info('');
        $this->command->info('💡 See TEST_ACCOUNTS.md for detailed account information!');
        $this->command->info('');
    }

    /**
     * Helper method to create a recipe with ingredients and steps
     */
    private function createRecipe(User $user, array $data): Recipe
    {
        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'cook_time' => $data['cook_time'],
            'servings' => $data['servings'],
            'difficulty' => $data['difficulty'] ?? 'medium',
            'cuisine_type' => $data['cuisine'] ?? 'International',
            'category' => $data['category'] ?? 'Dinner',
            'dietary_tags' => $data['dietary_tags'] ?? null,
            'status' => $data['status'],
            'rejection_reason' => $data['rejection_reason'] ?? null,
            'photo_path' => $data['photo_path'] ?? null,
        ]);

        // Add ingredients
        foreach ($data['ingredients'] as $index => $ingredient) {
            Ingredient::create([
                'recipe_id' => $recipe->id,
                'name' => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
                'order' => $index + 1,
            ]);
        }

        // Add steps
        foreach ($data['steps'] as $index => $stepDescription) {
            RecipeStep::create([
                'recipe_id' => $recipe->id,
                'step_number' => $index + 1,
                'description' => $stepDescription,
            ]);
        }

        return $recipe;
    }
}
