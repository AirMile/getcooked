<form action="{{ $action }}" method="POST" enctype="multipart/form-data" x-data="recipeForm()">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    {{-- Title --}}
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $recipe->title ?? '') }}" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $recipe->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Photo --}}
    <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
        @if($recipe && $recipe->photo_path)
            <div class="mb-2">
                <img src="{{ Storage::url($recipe->photo_path) }}" alt="Current photo" class="h-32 w-auto rounded">
            </div>
        @endif
        <input type="file" name="photo" id="photo" accept="image/*"
            class="mt-1 block w-full">
        @error('photo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Cook Time, Difficulty, Servings --}}
    <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
            <label for="cook_time" class="block text-sm font-medium text-gray-700">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" value="{{ old('cook_time', $recipe->cook_time ?? '') }}" required min="1"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('cook_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="difficulty" class="block text-sm font-medium text-gray-700">Difficulty</label>
            <select name="difficulty" id="difficulty" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="easy" {{ old('difficulty', $recipe->difficulty ?? '') === 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ old('difficulty', $recipe->difficulty ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ old('difficulty', $recipe->difficulty ?? '') === 'hard' ? 'selected' : '' }}>Hard</option>
            </select>
            @error('difficulty')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="servings" class="block text-sm font-medium text-gray-700">Servings</label>
            <input type="number" name="servings" id="servings" value="{{ old('servings', $recipe->servings ?? 1) }}" required min="1"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('servings')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Cuisine Type & Category --}}
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label for="cuisine_type" class="block text-sm font-medium text-gray-700">Cuisine Type</label>
            <input type="text" name="cuisine_type" id="cuisine_type" value="{{ old('cuisine_type', $recipe->cuisine_type ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Italian, Mexican">
            @error('cuisine_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" id="category" value="{{ old('category', $recipe->category ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Dessert, Main Course">
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Dietary Tags (multi-select checkboxes) --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Dietary Tags</label>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            @foreach(['vegetarian', 'vegan', 'pescatarian', 'keto', 'paleo', 'gluten-free', 'dairy-free', 'nut-free', 'egg-free', 'soy-free', 'shellfish-free', 'fish-free'] as $tag)
                <label class="flex items-center">
                    <input type="checkbox" name="dietary_tags[]" value="{{ $tag }}"
                        {{ in_array($tag, old('dietary_tags', $recipe->dietary_tags ?? [])) ? 'checked' : '' }}
                        class="rounded border-gray-300">
                    <span class="ml-2 text-sm">{{ ucfirst($tag) }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Ingredients (dynamic with Alpine.js) --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Ingredients</label>
        <template x-for="(ingredient, index) in ingredients" :key="index">
            <div class="flex gap-2 mb-2">
                <input type="text" :name="`ingredients[${index}][name]`" x-model="ingredient.name" placeholder="Ingredient name" required
                    class="flex-1 rounded-md border-gray-300 shadow-sm">
                <input type="number" :name="`ingredients[${index}][amount]`" x-model="ingredient.amount" placeholder="Amount" required step="0.01" min="0"
                    class="w-24 rounded-md border-gray-300 shadow-sm">
                <input type="text" :name="`ingredients[${index}][unit]`" x-model="ingredient.unit" placeholder="Unit" required
                    class="w-24 rounded-md border-gray-300 shadow-sm">
                <button type="button" @click="removeIngredient(index)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
            </div>
        </template>
        <button type="button" @click="addIngredient()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 mt-2">Add Ingredient</button>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end gap-2">
        <a href="{{ route('recipes.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">{{ $recipe ? 'Update' : 'Create' }} Recipe</button>
    </div>
</form>

@php
    // Prepare ingredients data for Alpine.js
    $ingredientsData = old('ingredients');

    if (!$ingredientsData && $recipe && $recipe->ingredients) {
        $ingredientsData = $recipe->ingredients->map(function($i) {
            return [
                'name' => $i->name,
                'amount' => $i->amount,
                'unit' => $i->unit
            ];
        })->toArray();
    }

    if (!$ingredientsData) {
        $ingredientsData = [['name' => '', 'amount' => '', 'unit' => '']];
    }
@endphp

<script>
function recipeForm() {
    return {
        ingredients: @json($ingredientsData),
        addIngredient() {
            this.ingredients.push({ name: '', amount: '', unit: '' });
        },
        removeIngredient(index) {
            if (this.ingredients.length > 1) {
                this.ingredients.splice(index, 1);
            }
        }
    }
}
</script>
