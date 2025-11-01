<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- My Recipes --}}
            <div class="mb-8">
                <h1 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">My Recipes</h1>
                @if($myRecipes->isEmpty())
                    <p class="text-gray-600">You haven't created any recipes yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myRecipes as $recipe)
                            @include('recipes.partials.recipe-card', ['recipe' => $recipe])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Public Recipes --}}
            <div>
                <h2 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">Public Recipes</h2>
                @if($publicRecipes->isEmpty())
                    <p class="text-gray-600">No public recipes available yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($publicRecipes as $recipe)
                            @include('recipes.partials.recipe-card', ['recipe' => $recipe])
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $publicRecipes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
