<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">
                {{ __('Browse Recipes') }}
            </h1>

            @if($recipes->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recipes as $recipe)
                        {{-- Recipe Card --}}
                        <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition-shadow duration-base border border-gray-200">
                            {{-- Recipe Photo --}}
                            @if($recipe->photo_path)
                                <div class="h-48 bg-gray-100 overflow-hidden">
                                    <img src="{{ Storage::url($recipe->photo_path) }}"
                                         alt="{{ $recipe->title }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Recipe Content --}}
                            <div class="p-5">
                                {{-- Title --}}
                                <h3 class="font-primary text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $recipe->title }}
                                </h3>

                                {{-- Author --}}
                                <p class="text-sm text-gray-500 mb-3 flex items-center gap-1">
                                    <span>by {{ $recipe->user->name }}</span>
                                    @if($recipe->user->is_verified)
                                        <svg class="inline-block w-4 h-4 text-info" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </p>

                                {{-- Metadata --}}
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                    {{-- Cook Time --}}
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $recipe->cook_time }} min</span>
                                    </div>

                                    {{-- Difficulty --}}
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span class="capitalize">{{ $recipe->difficulty }}</span>
                                    </div>

                                    {{-- Servings --}}
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>{{ $recipe->servings }}</span>
                                    </div>
                                </div>

                                {{-- Like Percentage --}}
                                <div class="flex items-center gap-1 text-secondary-500 mb-4">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $recipe->like_percentage }}%</span>
                                </div>

                                {{-- View Button --}}
                                <a href="{{ route('recipes.show', $recipe) }}"
                                   class="block w-full text-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                                    View Recipe
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="font-primary mt-4 text-lg font-medium text-gray-900">No recipes found</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            @if(request()->has('search') || request()->has('difficulty') || request()->has('cook_time') || request()->has('meal_type') || request()->has('cuisine') || request()->has('dietary_tags'))
                                No recipes match your current filters. Try adjusting your search or filters.
                            @else
                                Be the first to create and share a recipe with the community!
                            @endif
                        </p>
                        <div class="mt-6">
                            @if(request()->has('search') || request()->has('difficulty') || request()->has('cook_time') || request()->has('meal_type') || request()->has('cuisine') || request()->has('dietary_tags'))
                                <a href="{{ route('browse') }}"
                                   class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                                    Clear Filters
                                </a>
                            @else
                                <a href="{{ route('recipes.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                                    Create Recipe
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Pagination --}}
            @if($recipes->hasPages())
                <div class="mt-6">
                    {{ $recipes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
