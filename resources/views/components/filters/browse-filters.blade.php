@props(['filters'])

{{-- Browse Page Filters: Dietary Tags, Cuisine Type, Difficulty, Cook Time, Meal Type --}}
<div x-data="filterManager({{ json_encode($filters) }})" class="p-4">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-900">Filters</h3>
        <button
            @click="clearAllFilters()"
            class="text-xs text-primary-600 hover:text-primary-700 font-medium"
        >
            Clear all
        </button>
    </div>

    {{-- Difficulty --}}
    <div class="mb-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Difficulty</h4>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="checkbox" value="easy" :checked="filters.difficulty.includes('easy')" @click="toggleFilter('difficulty', 'easy')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Easy</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="medium" :checked="filters.difficulty.includes('medium')" @click="toggleFilter('difficulty', 'medium')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Medium</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="hard" :checked="filters.difficulty.includes('hard')" @click="toggleFilter('difficulty', 'hard')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Hard</span>
            </label>
        </div>
    </div>

    {{-- Cook Time --}}
    <div class="mb-4 border-t border-gray-200 pt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Cook Time</h4>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="checkbox" value="quick" :checked="filters.cook_time.includes('quick')" @click="toggleFilter('cook_time', 'quick')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Quick (0-15 min)</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="medium" :checked="filters.cook_time.includes('medium')" @click="toggleFilter('cook_time', 'medium')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Medium (16-30 min)</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="long" :checked="filters.cook_time.includes('long')" @click="toggleFilter('cook_time', 'long')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Long (31-60 min)</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="very_long" :checked="filters.cook_time.includes('very_long')" @click="toggleFilter('cook_time', 'very_long')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Very Long (60+ min)</span>
            </label>
        </div>
    </div>

    {{-- Meal Type --}}
    <div class="mb-4 border-t border-gray-200 pt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Meal Type</h4>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="checkbox" value="breakfast" :checked="filters.meal_type.includes('breakfast')" @click="toggleFilter('meal_type', 'breakfast')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Breakfast</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="lunch" :checked="filters.meal_type.includes('lunch')" @click="toggleFilter('meal_type', 'lunch')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Lunch</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="dinner" :checked="filters.meal_type.includes('dinner')" @click="toggleFilter('meal_type', 'dinner')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Dinner</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="snack" :checked="filters.meal_type.includes('snack')" @click="toggleFilter('meal_type', 'snack')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Snack</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="dessert" :checked="filters.meal_type.includes('dessert')" @click="toggleFilter('meal_type', 'dessert')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Dessert</span>
            </label>
        </div>
    </div>

    {{-- Cuisine Type --}}
    <div class="mb-4 border-t border-gray-200 pt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Cuisine</h4>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="checkbox" value="italian" :checked="filters.cuisine.includes('italian')" @click="toggleFilter('cuisine', 'italian')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Italian</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="chinese" :checked="filters.cuisine.includes('chinese')" @click="toggleFilter('cuisine', 'chinese')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Chinese</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="mexican" :checked="filters.cuisine.includes('mexican')" @click="toggleFilter('cuisine', 'mexican')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Mexican</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="indian" :checked="filters.cuisine.includes('indian')" @click="toggleFilter('cuisine', 'indian')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Indian</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="japanese" :checked="filters.cuisine.includes('japanese')" @click="toggleFilter('cuisine', 'japanese')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Japanese</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="mediterranean" :checked="filters.cuisine.includes('mediterranean')" @click="toggleFilter('cuisine', 'mediterranean')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Mediterranean</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="american" :checked="filters.cuisine.includes('american')" @click="toggleFilter('cuisine', 'american')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">American</span>
            </label>
        </div>
    </div>

    {{-- Dietary Tags --}}
    <div class="border-t border-gray-200 pt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Dietary</h4>
        <div class="space-y-2">
            <label class="flex items-center">
                <input type="checkbox" value="vegetarian" :checked="filters.dietary_tags.includes('vegetarian')" @click="toggleFilter('dietary_tags', 'vegetarian')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Vegetarian</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="vegan" :checked="filters.dietary_tags.includes('vegan')" @click="toggleFilter('dietary_tags', 'vegan')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Vegan</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="gluten-free" :checked="filters.dietary_tags.includes('gluten-free')" @click="toggleFilter('dietary_tags', 'gluten-free')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Gluten-Free</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="dairy-free" :checked="filters.dietary_tags.includes('dairy-free')" @click="toggleFilter('dietary_tags', 'dairy-free')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Dairy-Free</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="keto" :checked="filters.dietary_tags.includes('keto')" @click="toggleFilter('dietary_tags', 'keto')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Keto</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" value="low-carb" :checked="filters.dietary_tags.includes('low-carb')" @click="toggleFilter('dietary_tags', 'low-carb')" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-600">Low-Carb</span>
            </label>
        </div>
    </div>
</div>

<script>
function filterManager(initialFilters) {
    return {
        filters: {},
        init() {
            // Parse filters from URL on component initialization
            const url = new URL(window.location.href);
            this.filters = {
                search: url.searchParams.get('search') || '',
                difficulty: url.searchParams.getAll('difficulty[]'),
                cook_time: url.searchParams.getAll('cook_time[]'),
                meal_type: url.searchParams.getAll('meal_type[]'),
                cuisine: url.searchParams.getAll('cuisine[]'),
                dietary_tags: url.searchParams.getAll('dietary_tags[]'),
            };
        },
        toggleFilter(filterKey, value) {
            // Ensure filter is an array
            if (!Array.isArray(this.filters[filterKey])) {
                this.filters[filterKey] = [];
            }

            // Toggle the value in the array
            const index = this.filters[filterKey].indexOf(value);
            if (index > -1) {
                this.filters[filterKey].splice(index, 1);
            } else {
                this.filters[filterKey].push(value);
            }

            // Apply filters after toggle
            this.applyFilters();
        },
        applyFilters() {
            const url = new URL(window.location.href);

            // Reset pagination
            url.searchParams.delete('page');

            // Apply each filter
            Object.keys(this.filters).forEach(key => {
                url.searchParams.delete(`${key}[]`);
                url.searchParams.delete(key);

                if (Array.isArray(this.filters[key]) && this.filters[key].length > 0) {
                    this.filters[key].forEach(value => {
                        url.searchParams.append(`${key}[]`, value);
                    });
                } else if (this.filters[key] && !Array.isArray(this.filters[key])) {
                    url.searchParams.set(key, this.filters[key]);
                }
            });

            window.location.href = url.toString();
        },
        clearAllFilters() {
            const url = new URL(window.location.href);
            url.searchParams.delete('difficulty[]');
            url.searchParams.delete('cook_time[]');
            url.searchParams.delete('meal_type[]');
            url.searchParams.delete('cuisine[]');
            url.searchParams.delete('dietary_tags[]');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
    };
}
</script>
