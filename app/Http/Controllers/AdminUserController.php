<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Toggle user verified status.
     */
    public function toggleVerified(User $user)
    {
        try {
            $user->toggleVerified();

            // Return HTML fragment for Alpine.js x-target replacement
            return response()->view('admin.partials.verified-badge', [
                'isVerified' => $user->is_verified
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to toggle verified status'
            ], 500);
        }
    }

    /**
     * Toggle recipe privacy status (private <-> approved).
     */
    public function toggleRecipePrivacy(Recipe $recipe)
    {
        try {
            $recipe->togglePrivacy();

            // Return HTML fragment for Alpine.js x-target replacement
            return response()->view('admin.partials.recipe-status-badge', [
                'status' => $recipe->status
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Recipe not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to toggle recipe privacy'
            ], 500);
        }
    }
}
