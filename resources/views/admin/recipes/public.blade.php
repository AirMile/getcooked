<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Public Recipes Moderation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <form method="GET" action="{{ route('admin.recipes.public') }}" class="flex gap-4">
                    <input type="text" name="search" placeholder="Search recipes..."
                        value="{{ request('search') }}"
                        class="flex-1 rounded-md border-gray-300">
                    <select name="sort" class="rounded-md border-gray-300">
                        <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Most Recent</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                    <button type="submit" class="btn-primary">Filter</button>
                    <a href="{{ route('admin.recipes.public') }}" class="btn-secondary">Clear</a>
                </form>
            </div>

            {{-- Public Recipes Grid --}}
            @if($publicRecipes->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-600">
                    No public recipes found.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($publicRecipes as $recipe)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($recipe->photo_path)
                                <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}"
                                    class="w-full h-48 object-cover">
                            @endif

                            <div class="p-4">
                                <h4 class="font-bold text-lg mb-2">{{ $recipe->title }}</h4>
                                <p class="text-sm text-gray-600 mb-2">By {{ $recipe->user->name }}</p>
                                <p class="text-sm text-gray-500 mb-4">
                                    👍 {{ $recipe->like_percentage }}% | 👎 {{ $recipe->dislike_percentage }}%
                                </p>

                                <div class="flex gap-2">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="btn-secondary flex-1 text-center text-sm">
                                        View
                                    </a>
                                    <button type="button" class="btn-danger flex-1 text-sm"
                                        @click="showModerateModal({{ $recipe->id }}, '{{ addslashes($recipe->title) }}')">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $publicRecipes->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Moderate/Delete Modal --}}
    <div x-data="moderateModal()" x-show="showModal" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-bold mb-4">Delete Recipe</h3>
            <p class="mb-4">Are you sure you want to delete: <strong x-text="recipeTitle"></strong>?</p>
            <p class="text-sm text-gray-600 mb-4">This action cannot be undone.</p>

            <form :action="`/admin/recipes/${recipeId}/moderate`" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Deletion
                    </label>
                    <textarea name="reason" id="reason" rows="4" required
                        class="w-full rounded-md border-gray-300"
                        placeholder="Explain why this recipe is being removed..."></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-danger">Delete Recipe</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function moderateModal() {
        return {
            showModal: false,
            recipeId: null,
            recipeTitle: '',
            showModerateModal(id, title) {
                this.recipeId = id;
                this.recipeTitle = title;
                this.showModal = true;
            }
        };
    }

    window.showModerateModal = function(id, title) {
        // This function is called from the inline @click
        // Alpine.js will handle it through the x-data directive
    };
    </script>
</x-app-layout>
