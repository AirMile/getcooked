<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-8 px-4 sm:px-0">
                <button onclick="window.history.back()" class="p-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-base" title="Back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>
                <h1 class="font-primary text-3xl font-semibold text-gray-700">
                    {{ __('Recipes by') }} {{ $user->name }}
                </h1>
            </div>
            {{-- User Info --}}
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-primary text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->is_verified)
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500">
                            Joined {{ $user->created_at->format('M d, Y') }} • {{ $user->recipes_count ?? $recipes->total() }} recipes
                        </p>
                    </div>
                    <div>
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Admin
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                User
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recipes List --}}
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                @if($recipes->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-primary mt-4 text-lg font-medium text-gray-900">No recipes yet</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            This user hasn't created any recipes yet.
                        </p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ingredients</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recipes as $recipe)
                                <tr x-data="{
                                    isPrivate: {{ in_array($recipe->status, ['private']) ? 'true' : 'false' }},
                                    canToggle: {{ in_array($recipe->status, ['private', 'approved']) ? 'true' : 'false' }}
                                }" class="hover:bg-gray-50 transition-colors duration-base">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($recipe->photo_path)
                                                <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}"
                                                    class="h-16 w-16 rounded-lg object-cover shadow-sm border border-gray-200 flex-shrink-0">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center border border-gray-200 flex-shrink-0">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <div class="font-semibold text-gray-900 mb-1">{{ $recipe->title }}</div>
                                                <div class="text-sm text-gray-500 mb-2">{{ Str::limit($recipe->description, 50) }}</div>
                                                <div class="flex gap-3 text-xs text-gray-400">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $recipe->cook_time }} min
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                        {{ ucfirst($recipe->difficulty) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <span id="recipe-status-badge-{{ $recipe->id }}">
                                                @include('admin.partials.recipe-status-badge', ['status' => $recipe->status])
                                            </span>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    type="button"
                                                    @click="if(canToggle) { $el.blur(); isPrivate = !isPrivate; fetch('{{ route('admin.recipes.toggle-privacy', $recipe) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } }).then(r => r.ok ? r.text().then(html => document.getElementById('recipe-status-badge-{{ $recipe->id }}').innerHTML = html) : (isPrivate = !isPrivate)) }"
                                                    :class="canToggle ? (!isPrivate ? 'bg-secondary-600' : 'bg-gray-300') : 'bg-gray-200 cursor-not-allowed opacity-50'"
                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                    :class="{ 'cursor-pointer': canToggle }"
                                                    role="switch"
                                                    :aria-checked="!isPrivate"
                                                    :disabled="!canToggle"
                                                    :title="canToggle ? 'Toggle privacy' : 'Cannot toggle pending/rejected recipes'">
                                                    <span
                                                        :class="!isPrivate ? 'translate-x-5' : 'translate-x-0'"
                                                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                                </button>
                                                <span class="text-xs text-gray-500" x-text="canToggle ? (isPrivate ? 'Private' : 'Public') : 'Locked'"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $recipe->ingredients->count() }} ingredients
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $recipe->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2" x-data="{ showDeleteModal: false, deleteReason: '' }">
                                            <a href="{{ route('recipes.show', $recipe) }}" class="p-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base inline-block" title="View Recipe">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            @if(in_array($recipe->status, ['approved', 'pending', 'rejected']))
                                                <button @click="showDeleteModal = true" type="button" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-base inline-block" title="Delete Recipe">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>

                                                {{-- Delete Modal --}}
                                                <div x-show="showDeleteModal"
                                                     x-cloak
                                                     @click.away="showDeleteModal = false"
                                                     class="fixed inset-0 z-50 overflow-y-auto"
                                                     style="display: none;">
                                                    <div class="flex items-center justify-center min-h-screen px-4">
                                                        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

                                                        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                                                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Delete Recipe</h3>

                                                            <p class="text-sm text-gray-600 mb-4">
                                                                Are you sure you want to delete "<strong>{{ $recipe->title }}</strong>"? This action cannot be undone.
                                                            </p>

                                                            <form method="POST" action="{{ route('admin.recipes.moderate', $recipe) }}">
                                                                @csrf
                                                                @method('DELETE')

                                                                <div class="mb-4">
                                                                    <label for="delete-reason-{{ $recipe->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                                                        Deletion Reason <span class="text-red-500">*</span>
                                                                    </label>
                                                                    <textarea
                                                                        id="delete-reason-{{ $recipe->id }}"
                                                                        name="reason"
                                                                        x-model="deleteReason"
                                                                        rows="3"
                                                                        required
                                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                                        placeholder="Provide a reason for deleting this recipe..."></textarea>
                                                                </div>

                                                                <div class="flex gap-3 justify-end">
                                                                    <button type="button"
                                                                            @click="showDeleteModal = false; deleteReason = ''"
                                                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-base">
                                                                        Cancel
                                                                    </button>
                                                                    <button type="submit"
                                                                            :disabled="deleteReason.trim().length === 0"
                                                                            :class="deleteReason.trim().length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-700'"
                                                                            class="px-4 py-2 bg-red-600 text-white rounded-md transition-colors duration-base">
                                                                        Delete Recipe
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $recipes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
