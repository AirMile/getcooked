<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8 px-4 sm:px-0">
                <div class="flex items-center gap-4">
                    <button onclick="localStorage.removeItem('recipe_form_edit_{{ $recipe->id }}'); window.history.back();" class="p-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-base" title="Back">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </button>
                    <h1 class="font-primary text-3xl font-semibold text-gray-700">
                        {{ __('Edit Recipe') }}
                    </h1>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Toggle Privacy Button --}}
                    <form method="POST" action="{{ route('recipes.toggle-privacy', $recipe) }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-base text-sm font-medium"
                                title="{{ $recipe->is_private ? 'Make Public' : 'Make Private' }}">
                            @if($recipe->is_private)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"/>
                                </svg>
                                <span>Make Public</span>
                            @else
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                                </svg>
                                <span>Make Private</span>
                            @endif
                        </button>
                    </form>

                    {{-- Delete Button --}}
                    <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this recipe? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center w-10 h-10 border border-red-300 bg-white text-red-600 hover:bg-red-50 rounded-md transition-colors duration-base"
                                title="Delete Recipe">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200">
                <div class="p-6">
                    @include('recipes.partials.recipe-form', [
                        'action' => route('recipes.update', $recipe),
                        'method' => 'PUT',
                        'recipe' => $recipe,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
