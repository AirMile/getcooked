<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Recipes') }}
            </h2>
            <a href="{{ route('recipes.create') }}" class="btn-primary">
                Create Recipe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- My Recipes --}}
            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-4">My Recipes</h3>
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
                <h3 class="text-2xl font-bold mb-4">Public Recipes</h3>
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
