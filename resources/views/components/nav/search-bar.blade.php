{{-- Search Bar Component with Enter-to-Search, Clear Icon, and Filter Button --}}
<div
    x-data="{
        searchTerm: '{{ request()->input('search') ?? '' }}',
        filterPanelOpen: false,
        performSearch() {
            const url = new URL(window.location.href);
            if (this.searchTerm.trim()) {
                url.searchParams.set('search', this.searchTerm.trim());
            } else {
                url.searchParams.delete('search');
            }
            // Reset to page 1 when searching
            url.searchParams.delete('page');
            window.location.href = url.toString();
        },
        clearSearch() {
            this.searchTerm = '';
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
    }"
    class="relative w-full max-w-lg"
>
    <input
        type="text"
        placeholder="Search recipes..."
        x-model="searchTerm"
        @keydown.enter="performSearch()"
        class="w-full px-4 py-2.5 pr-24 text-base border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent transition-shadow duration-base"
    >
    <div class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center gap-1">
        <button
            x-show="searchTerm.length > 0"
            @click="clearSearch()"
            class="p-1.5 text-gray-400 hover:text-gray-600 rounded-md transition-colors duration-base"
            title="Clear search"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <button
            @click="filterPanelOpen = !filterPanelOpen"
            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md transition-colors duration-base"
            title="Filters"
            :class="{ 'text-primary-600 bg-primary-50': filterPanelOpen }"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
        </button>
    </div>

    {{-- Filter Panel Component --}}
    <div
        x-show="filterPanelOpen"
        @click.away="filterPanelOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50 max-h-96 overflow-y-auto"
        style="display: none;"
    >
        @if(request()->routeIs('browse'))
            <x-filters.browse-filters :filters="$filters ?? []" />
        @elseif(request()->routeIs('collection'))
            <x-filters.collection-filters :filters="$filters ?? []" />
        @endif
    </div>
</div>
