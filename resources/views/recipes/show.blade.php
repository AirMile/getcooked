<x-app-layout>
    <div class="py-12" x-data='{ pendingRecipe: @json($pendingRecipe ?? null) }'>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Page heading --}}
            <div class="mb-4 px-4 sm:px-0">
                <h1 class="font-primary text-4xl font-semibold text-gray-700">
                    {{ $recipe->title }}
                </h1>
            </div>

            {{-- Author info --}}
            @if($recipe->user_id !== auth()->id())
                <div class="mb-6 pl-3">
                    <span class="text-sm text-gray-500 flex items-center gap-1">
                        By {{ $recipe->user->name }}
                        @if($recipe->user->is_verified)
                            <svg class="inline-block w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </span>
                </div>
            @else
                <div class="mb-6"></div>
            @endif

            {{-- Back button and Actions --}}
            <div class="mb-6 flex items-center justify-between px-4 sm:px-0">
                <button onclick="
                    @if(session('success'))
                        window.history.length > 2 ? window.history.go(-2) : window.history.back()
                    @else
                        window.history.back()
                    @endif
                " class="p-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-base" title="Back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>

                <div class="flex gap-2">
                @can('submitForApproval', $recipe)
                    <form action="{{ route('recipes.submit', $recipe) }}" method="POST"
                          @submit.prevent="if (pendingRecipe) { $dispatch('open-modal', 'pending-recipe-limit'); } else { $el.submit(); }">
                        @csrf
                        <button type="submit" class="p-2 bg-secondary-500 text-white rounded-md hover:bg-secondary-600 transition-colors duration-base" title="Submit for Approval">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </form>
                @endcan

                @can('withdraw', $recipe)
                    <form action="{{ route('recipes.withdraw', $recipe) }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-base" title="Withdraw">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </form>
                @endcan

                @can('update', $recipe)
                    <a href="{{ route('recipes.edit', $recipe) }}" class="p-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                @endcan

                @can('delete', $recipe)
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-error text-white rounded-md hover:bg-red-700 transition-colors duration-base" title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                @endcan
                </div>
            </div>

            {{-- Photo --}}
            @if($recipe->photo_path)
                <div class="mb-6">
                    <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}" class="w-full rounded-lg shadow-lg border border-gray-200">
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md rounded-lg mb-6 border border-gray-200">
                <div class="p-6">
                    {{-- Description --}}
                    <div class="mb-6">
                        <h3 class="font-primary text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $recipe->description }}</p>
                    </div>

                    {{-- Recipe info --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <span class="text-sm text-gray-500">Cook Time</span>
                            <p class="font-semibold text-gray-900">{{ $recipe->cook_time }} min</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Difficulty</span>
                            <p class="font-semibold text-gray-900">{{ ucfirst($recipe->difficulty) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Servings</span>
                            <p class="font-semibold text-gray-900">{{ $recipe->servings }}</p>
                        </div>
                        @if($recipe->cuisine_type)
                            <div>
                                <span class="text-sm text-gray-500">Cuisine</span>
                                <p class="font-semibold text-gray-900">{{ $recipe->cuisine_type }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Dietary Tags --}}
                    @if(!empty($recipe->dietary_tags))
                        <div class="mb-6">
                            <h3 class="font-primary text-lg font-semibold text-gray-900 mb-2">Dietary Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($recipe->dietary_tags as $tag)
                                    <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-sm font-medium">{{ ucfirst($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Ingredients --}}
                    <div class="mb-6">
                        <h3 class="font-primary text-lg font-semibold text-gray-900 mb-2">Ingredients</h3>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient->amount }} {{ $ingredient->unit }} {{ $ingredient->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Preparation Steps --}}
                    <div class="mb-6">
                        <h3 class="font-primary text-lg font-semibold text-gray-900 mb-2">Preparation Steps</h3>
                        <ol class="space-y-3">
                            @foreach($recipe->steps as $step)
                                <li class="flex gap-3">
                                    <span class="font-semibold text-gray-500">{{ $step->step_number }}.</span>
                                    <span class="text-gray-700">{{ $step->description }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Social features (only for approved recipes from other users) --}}
                    @if($recipe->status === 'approved' && $recipe->user_id !== auth()->id())
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between">
                                {{-- Like/Dislike --}}
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('recipes.like', $recipe) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-md transition-colors duration-base {{ $userLike && $userLike->is_like ? 'bg-secondary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}" title="Like">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('recipes.dislike', $recipe) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-md transition-colors duration-base {{ $userLike && !$userLike->is_like ? 'bg-error text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}" title="Dislike">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                {{-- Save to library --}}
                                <div>
                                    @if($isSaved)
                                        <form action="{{ route('recipes.unsave', $recipe) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-secondary-500 text-white rounded-md hover:bg-secondary-600 transition-colors duration-base" title="Remove from Library">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('recipes.save', $recipe) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-md transition-colors duration-base" title="Save to Library">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Pending Recipe Limit Modal --}}
        <x-modal name="pending-recipe-limit" :show="false">
            <div class="p-6">
                <h2 class="font-primary text-lg font-semibold text-gray-900 mb-4">Pending Recipe Limit Reached</h2>
                <p class="text-gray-700 mb-4">You already have a pending recipe waiting for approval. You must wait for it to be reviewed before submitting another recipe.</p>

                <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Your pending recipe:</p>
                    <p class="font-semibold text-gray-900" x-text="pendingRecipe?.title || 'Unknown Recipe'"></p>
                </div>

                <div class="flex gap-2 justify-end">
                    <template x-if="pendingRecipe">
                        <a :href="'/recipes/' + pendingRecipe.id" class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base">
                            View Pending Recipe
                        </a>
                    </template>
                    <button @click="$dispatch('close-modal', 'pending-recipe-limit')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-base">
                        Close
                    </button>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
