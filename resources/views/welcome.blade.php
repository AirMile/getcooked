<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GetCooked - Share Your Culinary Creations</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/getcooked_logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=lora:400,500,600,700|lato:400,700" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('images/getcooked_logo_nav.png') }}" alt="GetCooked" class="h-8 w-auto">
                    </div>

                    <!-- Auth Links -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-base text-gray-700 hover:text-gray-900 transition-colors duration-base">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 border border-primary-500 text-primary-600 rounded-md hover:bg-primary-50 transition-colors duration-base">
                            Sign up
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- Main Headline -->
                <h1 class="font-primary text-5xl md:text-6xl font-bold text-gray-800 mb-6">
                    Share Your Culinary<br>
                    <span class="text-primary-600">Creations</span>
                </h1>

                <!-- Tagline -->
                <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto">
                    Discover, create, and share delicious recipes with a community of food enthusiasts. Your kitchen adventures start here.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-primary-500 text-white text-lg font-medium rounded-lg hover:bg-primary-600 transition-colors duration-base shadow-lg hover:shadow-xl">
                        Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-gray-700 text-lg font-medium rounded-lg border-2 border-gray-300 hover:border-gray-400 transition-colors duration-base">
                        Sign In
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <h2 class="font-primary text-3xl md:text-4xl font-bold text-gray-800 text-center mb-16">
                Everything You Need to Share Recipes
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition-shadow duration-base">
                    <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="font-primary text-xl font-semibold text-gray-800 mb-2">
                        Create & Share
                    </h3>
                    <p class="text-gray-600">
                        Easily create beautiful recipe cards with step-by-step instructions, ingredients, and photos.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition-shadow duration-base">
                    <div class="w-14 h-14 bg-secondary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-primary text-xl font-semibold text-gray-800 mb-2">
                        Discover Recipes
                    </h3>
                    <p class="text-gray-600">
                        Browse thousands of recipes with advanced filters for dietary needs, cuisine types, and difficulty levels.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition-shadow duration-base">
                    <div class="w-14 h-14 bg-info-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-info-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="font-primary text-xl font-semibold text-gray-800 mb-2">
                        Save Favorites
                    </h3>
                    <p class="text-gray-600">
                        Build your personal collection of favorite recipes and access them anytime, anywhere.
                    </p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <h2 class="font-primary text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Ready to Get Cooking?
                </h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Join our community of home chefs and food lovers. It's free to start sharing your recipes today.
                </p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-primary-500 text-white text-lg font-medium rounded-lg hover:bg-primary-600 transition-colors duration-base shadow-lg hover:shadow-xl">
                    Create Your Account
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-gray-600">
                    <p>&copy; {{ date('Y') }} GetCooked. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
