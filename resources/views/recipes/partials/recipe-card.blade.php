<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
    @if($recipe->photo_path)
        <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <span class="text-gray-400">No image</span>
        </div>
    @endif

    <div class="p-4">
        <div class="flex items-center justify-between mb-2">
            <h4 class="font-bold text-lg">{{ $recipe->title }}</h4>
            <span class="px-2 py-1 text-xs rounded-full
                @if($recipe->status === 'private') bg-gray-200 text-gray-700
                @elseif($recipe->status === 'pending') bg-yellow-200 text-yellow-700
                @elseif($recipe->status === 'approved') bg-green-200 text-green-700
                @elseif($recipe->status === 'rejected') bg-red-200 text-red-700
                @endif">
                {{ ucfirst($recipe->status) }}
            </span>
        </div>

        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $recipe->description }}</p>

        <div class="flex items-center text-sm text-gray-500 mb-3">
            <span class="mr-4">{{ $recipe->cook_time }} min</span>
            <span class="mr-4">{{ $recipe->servings }} servings</span>
            <span>{{ ucfirst($recipe->difficulty) }}</span>
        </div>

        @if($recipe->status === 'approved')
            <div class="flex items-center text-sm text-gray-500 mb-3">
                <span class="mr-2">{{ $recipe->like_percentage }}%</span>
                <span>{{ $recipe->dislike_percentage }}%</span>
            </div>
        @endif

        <div class="flex gap-2">
            <a href="{{ route('recipes.show', $recipe) }}" class="btn-secondary flex-1 text-center">
                View
            </a>
            @can('update', $recipe)
                <a href="{{ route('recipes.edit', $recipe) }}" class="btn-primary flex-1 text-center">
                    Edit
                </a>
            @endcan
        </div>
    </div>
</div>
