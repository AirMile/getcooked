<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-8 px-4 sm:px-0">
                <button onclick="window.history.back()" class="p-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-base" title="Back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>
                <h1 class="font-primary text-3xl font-semibold text-gray-700">
                    {{ __('Create Recipe') }}
                </h1>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                <div class="p-6">
                    @include('recipes.partials.recipe-form', [
                        'action' => route('recipes.store'),
                        'method' => 'POST',
                        'recipe' => null,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
