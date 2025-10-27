<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($users->isEmpty())
                    <div class="p-8 text-center text-gray-600">
                        No users with recipes found.
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verified</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr x-data="{ verified: {{ $user->is_verified ? 'true' : 'false' }} }">
                                    <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                @click="$el.blur(); verified = !verified; fetch('{{ route('admin.users.toggle-verified', $user) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } }).then(r => r.ok ? r.text().then(html => document.getElementById('verified-badge-{{ $user->id }}').innerHTML = html) : (verified = !verified))"
                                                :class="verified ? 'bg-blue-600' : 'bg-gray-300'"
                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                role="switch"
                                                :aria-checked="verified">
                                                <span
                                                    :class="verified ? 'translate-x-5' : 'translate-x-0'"
                                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                            </button>
                                            <span id="verified-badge-{{ $user->id }}">
                                                @include('admin.partials.verified-badge', ['isVerified' => $user->is_verified])
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $user->recipes_count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.recipes', $user) }}" class="btn-secondary text-sm">
                                            View Recipes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
