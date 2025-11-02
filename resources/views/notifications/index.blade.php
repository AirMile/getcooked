<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8 px-4 sm:px-0">
                <h1 class="font-primary text-3xl font-semibold text-gray-700">
                    {{ __('Notifications') }}
                </h1>

                @if(Auth::user()->notifications()->count() > 0)
                    <form method="POST" action="{{ route('notifications.delete-all') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-base text-sm font-medium" title="Delete All Notifications">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete All
                        </button>
                    </form>
                @endif
            </div>
            @if($notifications->isEmpty())
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="font-primary text-lg font-medium text-gray-900">No notifications yet</p>
                    <p class="mt-2 text-sm text-gray-500">You'll see recipe status updates and admin messages here</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-base {{ $notification->read_at ? 'opacity-75' : 'border-l-4 border-l-primary-500' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    {{-- Notification icon and message --}}
                                    <div class="flex items-start gap-4 mb-3">
                                        @if($notification->data['status'] === 'approved')
                                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @elseif($notification->data['status'] === 'rejected')
                                            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @elseif($notification->data['status'] === 'deleted')
                                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 text-base">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Rejection reason --}}
                                    @if(isset($notification->data['rejection_reason']))
                                        <div class="mt-4 ml-14 p-4 bg-red-50 border border-red-200 rounded-md">
                                            <p class="text-sm font-semibold text-red-800 mb-1">Rejection Reason:</p>
                                            <p class="text-sm text-red-700">{{ $notification->data['rejection_reason'] }}</p>
                                        </div>
                                    @endif

                                    {{-- Deletion reason --}}
                                    @if(isset($notification->data['deletion_reason']))
                                        <div class="mt-4 ml-14 p-4 bg-gray-50 border border-gray-200 rounded-md">
                                            <p class="text-sm font-semibold text-gray-800 mb-1">Deletion Reason:</p>
                                            <p class="text-sm text-gray-700">{{ $notification->data['deletion_reason'] }}</p>
                                        </div>
                                    @endif

                                    {{-- Context-aware action button --}}
                                    <div class="mt-5 ml-14">
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($notification->data['status'] === 'approved')
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View Published Recipe
                                                </button>
                                            @elseif($notification->data['status'] === 'rejected')
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit & Resubmit Recipe
                                                </button>
                                            @elseif($notification->data['status'] === 'deleted')
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors duration-base text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    Create New Recipe
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>

                                {{-- Unread indicator --}}
                                @if(!$notification->read_at)
                                    <div class="ml-4 flex-shrink-0">
                                        <span class="inline-flex items-center justify-center w-2 h-2 bg-primary-500 rounded-full ring-4 ring-primary-100"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
