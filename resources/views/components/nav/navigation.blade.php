@props(['isAdmin' => false])

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Left: Logo + Nav Links -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('browse') }}">
                        <img src="{{ asset('images/getcooked_logo_nav.png') }}" alt="GetCooked" class="block h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:flex">
                    @if($isAdmin)
                        <x-nav-link :href="route('admin.recipes.pending')" :active="request()->routeIs('admin.recipes.pending')">
                            {{ __('Pending Recipes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ __('Users Management') }}
                        </x-nav-link>
                        <x-nav-link :href="route('browse')" :active="request()->routeIs('browse')">
                            {{ __('Browse') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('browse')" :active="request()->routeIs('browse')">
                            {{ __('Browse') }}
                        </x-nav-link>
                        <x-nav-link :href="route('collection')" :active="request()->routeIs('collection')">
                            {{ __('Collection') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Center: Search Bar (Desktop) -->
            <div class="hidden sm:flex flex-1 justify-center px-8">
                <x-nav.search-bar />
            </div>

            <!-- Right: Create Recipe + Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @unless($isAdmin)
                    <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-primary-500 text-primary-600 rounded-md hover:bg-primary-50 transition-colors duration-base" title="Create Recipe">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="text-base font-medium">Create</span>
                    </a>
                @endunless
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2.5 border border-transparent text-base leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            @if($isAdmin)
                                <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>Admin</div>
                            @else
                                <div>{{ Auth::user()->name }}</div>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
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
                <x-responsive-nav-link :href="route('admin.recipes.pending')" :active="request()->routeIs('admin.recipes.pending')">
                    {{ __('Pending Recipes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    {{ __('Users Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('browse')" :active="request()->routeIs('browse')">
                    {{ __('Browse') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('browse')" :active="request()->routeIs('browse')">
                    {{ __('Browse') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('collection')" :active="request()->routeIs('collection')">
                    {{ __('Collection') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('recipes.create')" :active="request()->routeIs('recipes.create')">
                    {{ __('Create Recipe') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Search Bar (Mobile) -->
        <div class="px-4 pb-3">
            <x-nav.search-bar />
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
