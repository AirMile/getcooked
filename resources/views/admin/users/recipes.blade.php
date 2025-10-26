<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Recipes by') }} {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary text-sm">
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- User Info --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Joined: {{ $user->created_at->format('M d, Y') }} |
                            Total Recipes: {{ $user->recipes_count ?? $recipes->total() }}
                        </p>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Recipes List --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($recipes->isEmpty())
                    <div class="p-8 text-center text-gray-600">
                        This user hasn't created any recipes yet.
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
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($recipe->photo_path)
                                                <img src="{{ Storage::url($recipe->photo_path) }}" alt="{{ $recipe->title }}"
                                                    class="h-12 w-12 rounded object-cover mr-3">
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $recipe->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($recipe->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $recipe->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $recipe->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $recipe->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $recipe->status === 'private' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($recipe->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $recipe->ingredients->count() }} ingredients
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $recipe->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="btn-secondary text-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        {{ $recipes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
