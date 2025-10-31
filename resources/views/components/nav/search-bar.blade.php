{{-- Search Bar Component (Placeholder) --}}
<div class="relative w-full max-w-lg">
    <input
        type="text"
        placeholder="Search recipes..."
        disabled
        class="w-full px-4 py-2.5 pr-14 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 cursor-not-allowed"
    >
    <button
        disabled
        class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md cursor-not-allowed opacity-60 transition-colors duration-base"
        title="Filters"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
        </svg>
    </button>
</div>
