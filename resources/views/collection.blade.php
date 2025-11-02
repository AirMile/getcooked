<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">
                {{ __('My Collection') }}
            </h1>

            @if($recipes->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recipes as $recipe)
                        @include('recipes.partials.recipe-card', ['recipe' => $recipe, 'isCollectionView' => true])
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <h3 class="font-primary mt-4 text-lg font-medium text-gray-900">No recipes in your collection</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            @if(request()->has('search') || request()->has('source') || request()->has('difficulty') || request()->has('cook_time') || request()->has('meal_type'))
                                No recipes match your current filters. Try adjusting your search or filters.
                            @else
                                Start creating your own recipes or save recipes from the community!
                            @endif
                        </p>
                        <div class="mt-6 flex items-center justify-center gap-3">
                            @if(request()->has('search') || request()->has('source') || request()->has('difficulty') || request()->has('cook_time') || request()->has('meal_type'))
                                <a href="{{ route('collection') }}"
                                   class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                                    Clear Filters
                                </a>
                            @else
                                <a href="{{ route('recipes.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                                    Create Recipe
                                </a>
                                <a href="{{ route('browse') }}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-md transition-colors duration-base">
                                    Browse Recipes
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
