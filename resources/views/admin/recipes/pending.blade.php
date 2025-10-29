<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Recipes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        showModal: false,
        recipeId: null,
        recipeTitle: '',
        showRejectModal(id, title) {
            this.recipeId = id;
            this.recipeTitle = title;
            this.showModal = true;
        },
        submitReject(event) {
            if (!this.recipeId) {
                console.error('Recipe ID not set');
                return;
            }
            const form = event.target;
            form.action = `/admin/recipes/${this.recipeId}/reject`;
            form.submit();
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Statistics --}}
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-yellow-100 rounded-lg p-4">
                    <div class="text-2xl font-bold">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-600">Pending</div>
                </div>
                <div class="bg-green-100 rounded-lg p-4">
                    <div class="text-2xl font-bold">{{ $stats['approved'] }}</div>
                    <div class="text-sm text-gray-600">Approved</div>
                </div>
                <div class="bg-red-100 rounded-lg p-4">
                    <div class="text-2xl font-bold">{{ $stats['rejected'] }}</div>
                    <div class="text-sm text-gray-600">Rejected</div>
                </div>
                <div class="bg-blue-100 rounded-lg p-4">
                    <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Recipes</div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <form method="GET" action="{{ route('admin.recipes.pending') }}" class="flex gap-4">
                    <input type="text" name="search" placeholder="Search recipes..."
                        value="{{ request('search') }}"
                        class="flex-1 rounded-md border-gray-300">
                    <button type="submit" class="btn-primary">Search</button>
                    <a href="{{ route('admin.recipes.pending') }}" class="btn-secondary">Clear</a>
                </form>
            </div>

            {{-- Pending Recipes List --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($pendingRecipes->isEmpty())
                    <div class="p-8 text-center text-gray-600">
                        No pending recipes at the moment.
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendingRecipes as $recipe)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($recipe->photo_path)
                                                <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}"
                                                    class="h-16 w-16 rounded object-cover mr-4">
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $recipe->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($recipe->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>{{ $recipe->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $recipe->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $recipe->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('recipes.show', $recipe) }}" class="btn-secondary text-sm">View</a>

                                            <form method="POST" action="{{ route('admin.recipes.approve', $recipe) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="btn-primary text-sm"
                                                    onclick="return confirm('Approve this recipe?')">
                                                    Approve
                                                </button>
                                            </form>

                                            <button type="button" class="btn-danger text-sm"
                                                @click="showRejectModal({{ $recipe->id }}, '{{ addslashes($recipe->title) }}')">
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        {{ $pendingRecipes->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Reject Modal --}}
    <div x-show="showModal" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-bold mb-4">Reject Recipe</h3>
            <p class="mb-4">Rejecting: <strong x-text="recipeTitle"></strong></p>

            <form @submit.prevent="submitReject" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Rejection Reason
                    </label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                        class="w-full rounded-md border-gray-300"
                        placeholder="Explain why this recipe is being rejected..."></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-danger">Reject Recipe</button>
                </div>
            </form>
        </div>
    </div>
    </div>

</x-app-layout>
