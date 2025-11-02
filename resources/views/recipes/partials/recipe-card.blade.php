@php
    $isCollectionView = $isCollectionView ?? false;
@endphp
<div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition-shadow duration-base border border-gray-200 h-full flex flex-col cursor-pointer" onclick="window.location.href='{{ route('recipes.show', $recipe) }}'">
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
    <div class="p-5 flex flex-col flex-grow">
        {{-- Title with Status Badge --}}
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-primary text-lg font-semibold text-gray-900 line-clamp-2 flex-1">
                {{ $recipe->title }}
            </h3>
            @php
                $isOwnRecipe = $recipe->user_id === auth()->id();
            @endphp
            @if($isOwnRecipe)
                {{-- Only show pill badge for rejected --}}
                @if($recipe->status === 'rejected')
                    <span class="px-2 py-1 text-xs rounded-full ml-2 flex-shrink-0 flex items-center justify-center bg-red-200 text-red-700">
                        {{ ucfirst($recipe->status) }}
                    </span>
                @endif
            @else
                {{-- Badges for saved recipes from others - hide in collection view --}}
                @if(!$isCollectionView && $recipe->status === 'approved')
                    {{-- Bookmark icon for saved public recipes --}}
                    <span class="w-7 h-7 rounded-full ml-2 flex-shrink-0 flex items-center justify-center bg-gray-50 text-gray-700 border border-gray-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                        </svg>
                    </span>
                @endif
            @endif
        </div>

        {{-- Author --}}
        @if(isset($recipe->user) && $recipe->user)
            <p class="text-sm text-gray-500 mb-3 flex items-center gap-1 px-1">
                <span>by {{ $recipe->user->name }}</span>
                @if($recipe->user->is_verified)
                    <svg class="inline-block w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @endif
            </p>
        @endif

        {{-- Description - hide in collection view --}}
        @if(!$isCollectionView)
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $recipe->description }}</p>
        @endif

        {{-- Spacer to push bottom content down --}}
        <div class="flex-grow"></div>

        {{-- Like Percentage - Fixed position with min-height (always reserve space) --}}
        <div class="flex items-center gap-1 text-gray-500 mb-3 h-6">
            @if($recipe->status === 'approved')
                <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                </svg>
                <span class="font-medium text-secondary-500">{{ $recipe->like_percentage }}%</span>
            @elseif($recipe->status === 'pending' && $isOwnRecipe)
                {{-- Clock icon for pending recipes --}}
                <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
            @elseif($recipe->status === 'private' && $isOwnRecipe)
                {{-- Lock icon for private recipes --}}
                <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>

        {{-- Metadata - Fixed position --}}
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
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

        {{-- Action Buttons --}}
        <div class="flex gap-2 mt-auto">
            <span class="flex-grow items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-base text-center block">
                View Recipe
            </span>
            @if($isOwnRecipe)
                @can('update', $recipe)
                    <a href="{{ route('recipes.edit', $recipe) }}" title="Edit" onclick="event.stopPropagation()"
                       class="flex items-center justify-center w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-md transition-colors duration-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                @endcan
            @else
                {{-- Unsave button for saved recipes from other users --}}
                <form action="{{ route('recipes.unsave', $recipe) }}" method="POST" onclick="event.stopPropagation()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Unsave"
                            class="flex items-center justify-center w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-md transition-colors duration-base">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
