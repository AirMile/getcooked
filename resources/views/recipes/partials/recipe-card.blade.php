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

        @if(isset($recipe->user) && $recipe->user)
            <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                <span>by {{ $recipe->user->name }}</span>
                @if($recipe->user->is_verified)
                    <svg class="inline-block w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @endif
            </p>
        @endif

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
