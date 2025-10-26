<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $recipe->title }}
            </h2>
            <div class="flex gap-2">
                @can('update', $recipe)
                    <a href="{{ route('recipes.edit', $recipe) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Edit
                    </a>
                @endcan
                @can('delete', $recipe)
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Status badge and actions --}}
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($recipe->status === 'private') bg-gray-200 text-gray-700
                        @elseif($recipe->status === 'pending') bg-yellow-200 text-yellow-700
                        @elseif($recipe->status === 'approved') bg-green-200 text-green-700
                        @elseif($recipe->status === 'rejected') bg-red-200 text-red-700
                        @endif">
                        {{ ucfirst($recipe->status) }}
                    </span>
                    <span class="text-sm text-gray-600">By {{ $recipe->user->name }}</span>
                </div>

                <div class="flex gap-2">
                    @can('submitForApproval', $recipe)
                        <form action="{{ route('recipes.submit', $recipe) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Submit for Approval
                            </button>
                        </form>
                    @endcan

                    @can('withdraw', $recipe)
                        <form action="{{ route('recipes.withdraw', $recipe) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                Withdraw
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

            {{-- Photo --}}
            @if($recipe->photo_path)
                <div class="mb-6">
                    <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}" class="w-full rounded-lg shadow-lg">
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    {{-- Description --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $recipe->description }}</p>
                    </div>

                    {{-- Recipe info --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <span class="text-sm text-gray-600">Cook Time</span>
                            <p class="font-semibold">{{ $recipe->cook_time }} min</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Difficulty</span>
                            <p class="font-semibold">{{ ucfirst($recipe->difficulty) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Servings</span>
                            <p class="font-semibold">{{ $recipe->servings }}</p>
                        </div>
                        @if($recipe->cuisine_type)
                            <div>
                                <span class="text-sm text-gray-600">Cuisine</span>
                                <p class="font-semibold">{{ $recipe->cuisine_type }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Dietary Tags --}}
                    @if(!empty($recipe->dietary_tags))
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Dietary Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($recipe->dietary_tags as $tag)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">{{ ucfirst($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Ingredients --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Ingredients</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient->amount }} {{ $ingredient->unit }} {{ $ingredient->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Social features (only for approved recipes) --}}
                    @if($recipe->status === 'approved')
                        <div class="border-t pt-6">
                            <div class="flex items-center justify-between">
                                {{-- Like/Dislike --}}
                                <div class="flex items-center gap-4">
                                    <form action="{{ route('recipes.like', $recipe) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-md {{ $userLike && $userLike->is_like ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                            👍 {{ $recipe->like_percentage }}%
                                        </button>
                                    </form>

                                    <form action="{{ route('recipes.dislike', $recipe) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-md {{ $userLike && !$userLike->is_like ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                            👎 {{ $recipe->dislike_percentage }}%
                                        </button>
                                    </form>
                                </div>

                                {{-- Save to library --}}
                                <div>
                                    @if($isSaved)
                                        <form action="{{ route('recipes.unsave', $recipe) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                                Remove from Library
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('recipes.save', $recipe) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                Save to Library
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
    </div>
</x-app-layout>
