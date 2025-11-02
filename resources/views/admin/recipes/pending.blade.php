<x-app-layout>
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
            <h1 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">
                {{ __('Pending Recipes') }}
            </h1>

            {{-- Statistics --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg shadow-md p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-gray-600">Pending</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg shadow-md p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['approved'] }}</div>
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-gray-600">Approved</div>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg shadow-md p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['rejected'] }}</div>
                        <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-gray-600">Rejected</div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg shadow-md p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                        <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-sm font-medium text-gray-600">Total Recipes</div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 mb-6">
                <div class="relative" x-data="{ searchTerm: '{{ request('search') ?? '' }}' }">
                    <input type="text"
                        x-model="searchTerm"
                        @keydown.enter="window.location.href = '{{ route('admin.recipes.pending') }}' + (searchTerm ? '?search=' + encodeURIComponent(searchTerm) : '')"
                        placeholder="Search recipes..."
                        class="w-full rounded-md border-gray-300 focus:border-transparent focus:ring-1 focus:ring-primary-500 focus:outline-none pr-20">
                    <button
                        x-show="searchTerm.length > 0"
                        @click="searchTerm = ''; window.location.href = '{{ route('admin.recipes.pending') }}'"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1.5 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition-colors duration-base"
                        title="Clear search">
                        Clear
                    </button>
                </div>
            </div>

            {{-- Pending Recipes List --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
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
                                <tr class="hover:bg-gray-50 transition-colors duration-base">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($recipe->photo_path)
                                                <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}"
                                                    class="h-20 w-20 rounded-lg object-cover flex-shrink-0 shadow-sm">
                                            @else
                                                <div class="h-20 w-20 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <div class="font-semibold text-gray-900 mb-1">{{ $recipe->title }}</div>
                                                <div class="text-sm text-gray-500 line-clamp-2">{{ $recipe->description }}</div>
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
                                            <a href="{{ route('recipes.show', $recipe) }}"
                                               class="inline-flex items-center justify-center w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-md transition-colors duration-base"
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            <form method="POST" action="{{ route('admin.recipes.approve', $recipe) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center w-10 h-10 bg-secondary-500 hover:bg-secondary-600 text-white rounded-md transition-colors duration-base"
                                                        title="Approve">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            <button type="button"
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-error hover:bg-red-700 text-white rounded-md transition-colors duration-base"
                                                    @click="showRejectModal({{ $recipe->id }}, '{{ addslashes($recipe->title) }}')"
                                                    title="Reject">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-2">
                        {{ $pendingRecipes->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Reject Modal --}}
    <div x-show="showModal" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full" @click.outside="showModal = false">
            <div class="p-6">
                <h3 class="font-primary text-2xl font-semibold text-gray-900 mb-4">Reject Recipe</h3>
                <p class="text-gray-700 mb-6">
                    Rejecting: <strong class="text-gray-900" x-text="recipeTitle"></strong>
                </p>

                <form @submit.prevent="submitReject" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="rejection_reason" class="block text-base font-medium text-gray-700 mb-2">
                            Rejection Reason
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                            class="w-full rounded-md border-gray-300 focus:border-error focus:ring-error"
                            placeholder="Explain why this recipe is being rejected..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showModal = false"
                                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md transition-colors duration-base">
                            Cancel
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-error hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors duration-base">
                            Reject Recipe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
