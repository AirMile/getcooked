@props(['isAdmin' => false])

@php
    $unreadCount = Auth::user()->getCachedUnreadNotificationsCount();
@endphp

<nav x-data="{
    open: false,
    isNavigating: false,
    skipAnimation: false,
    init() {
        // Check if we came from another search page
        const cameFromSearchPage = sessionStorage.getItem('cameFromSearchPage') === 'true';
        const currentRoute = '{{ request()->route()->getName() }}';
        const isOnSearchPage = currentRoute === 'browse' || currentRoute === 'collection';

        if (cameFromSearchPage && isOnSearchPage) {
            this.skipAnimation = true;
        }

        // Clean up
        sessionStorage.removeItem('cameFromSearchPage');
    },
    navigateTo(url) {
        const currentRoute = '{{ request()->route()->getName() }}';
        const isOnSearchPage = currentRoute === 'browse' || currentRoute === 'collection';

        // Check if target URL is also a search page (browse or collection)
        const isTargetSearchPage = url.includes('/browse') || url.includes('/collection');

        // Remember if we're on a search page for the next page load
        if (isOnSearchPage && isTargetSearchPage) {
            sessionStorage.setItem('cameFromSearchPage', 'true');
        }

        // Only animate if leaving a search page to go to a non-search page
        if (isOnSearchPage && !isTargetSearchPage) {
            this.isNavigating = true;
            setTimeout(() => {
                window.location.href = url;
            }, 400);
        } else {
            window.location.href = url;
        }
    }
}" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Left: Logo + Nav Links -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('browse') }}" @click.prevent="navigateTo('{{ route('browse') }}')">
                        <img src="{{ asset('images/getcooked_logo_nav.png') }}" alt="GetCooked" class="block h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:flex">
                    @if($isAdmin)
                        <x-nav-link href="{{ route('admin.recipes.pending') }}" :active="request()->routeIs('admin.recipes.pending')" @click.prevent="navigateTo('{{ route('admin.recipes.pending') }}')">
                            {{ __('Pending Recipes') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')" @click.prevent="navigateTo('{{ route('admin.users.index') }}')">
                            {{ __('Users Management') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('browse') }}" :active="request()->routeIs('browse')" @click.prevent="navigateTo('{{ route('browse') }}')">
                            {{ __('Browse') }}
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('browse') }}" :active="request()->routeIs('browse')" @click.prevent="navigateTo('{{ route('browse') }}')">
                            {{ __('Browse') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('collection') }}" :active="request()->routeIs('collection')" @click.prevent="navigateTo('{{ route('collection') }}')">
                            {{ __('Collection') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Center: Search Bar (Desktop) - Only on Browse and Collection -->
            @if(request()->routeIs('browse') || request()->routeIs('collection'))
                <div class="hidden sm:flex flex-1 justify-center px-8"
                     :class="{
                         'animate-fade-out': isNavigating,
                         'animate-fade-in-down': !skipAnimation && !isNavigating
                     }">
                    <x-nav.search-bar />
                </div>
            @else
                <div class="flex-1"></div>
            @endif

            <!-- Right: Create Recipe + Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @unless($isAdmin)
                    <a href="{{ route('recipes.create') }}" @click.prevent="navigateTo('{{ route('recipes.create') }}')" class="inline-flex items-center gap-2 px-4 py-2 border border-primary-500 text-primary-600 rounded-md hover:bg-primary-50 transition-colors duration-base" title="Create Recipe">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="text-base font-medium">Create</span>
                    </a>
                @endunless
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2.5 border border-transparent text-base leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none focus:ring-0 focus:border-transparent transition ease-in-out duration-150">
                            @if($isAdmin)
                                <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            <div>{{ Auth::user()->name }}</div>

                            @if($unreadCount > 0)
                                <span class="ms-2 bg-primary-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('notifications.index') }}" @click.prevent="navigateTo('{{ route('notifications.index') }}')">
                            <div class="flex items-center justify-between w-full">
                                <span>{{ __('Notifications') }}</span>
                                @if($unreadCount > 0)
                                    <span class="bg-primary-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </div>
                        </x-dropdown-link>

                        <x-dropdown-link href="{{ route('profile.edit') }}" @click.prevent="navigateTo('{{ route('profile.edit') }}')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if($isAdmin)
                <x-responsive-nav-link href="{{ route('admin.recipes.pending') }}" :active="request()->routeIs('admin.recipes.pending')" @click.prevent="navigateTo('{{ route('admin.recipes.pending') }}')">
                    {{ __('Pending Recipes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')" @click.prevent="navigateTo('{{ route('admin.users.index') }}')">
                    {{ __('Users Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('browse') }}" :active="request()->routeIs('browse')" @click.prevent="navigateTo('{{ route('browse') }}')">
                    {{ __('Browse') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('browse') }}" :active="request()->routeIs('browse')" @click.prevent="navigateTo('{{ route('browse') }}')">
                    {{ __('Browse') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('collection') }}" :active="request()->routeIs('collection')" @click.prevent="navigateTo('{{ route('collection') }}')">
                    {{ __('Collection') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('recipes.create') }}" :active="request()->routeIs('recipes.create')" @click.prevent="navigateTo('{{ route('recipes.create') }}')">
                    {{ __('Create Recipe') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Search Bar (Mobile) - Only on Browse and Collection -->
        @if(request()->routeIs('browse') || request()->routeIs('collection'))
            <div class="px-4 pb-3"
                 :class="{
                     'animate-fade-out': isNavigating,
                     'animate-fade-in-down': !skipAnimation && !isNavigating
                 }">
                <x-nav.search-bar />
            </div>
        @endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('notifications.index') }}" @click.prevent="navigateTo('{{ route('notifications.index') }}')">
                    <div class="flex items-center justify-between w-full">
                        <span>{{ __('Notifications') }}</span>
                        @if($unreadCount > 0)
                            <span class="bg-primary-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('profile.edit') }}" @click.prevent="navigateTo('{{ route('profile.edit') }}')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
