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
            $user->is_verified = !$user->is_verified;
            $user->save();

            // Return HTML fragment for Alpine.js x-target replacement
            return response()->view('admin.partials.verified-badge', [
                'isVerified' => $user->is_verified
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to toggle verified status'
            ], 422);
        }
    }

    /**
     * Toggle recipe privacy status (private <-> approved).
     */
    public function toggleRecipePrivacy(Recipe $recipe)
    {
        try {
            // Toggle between private and approved
            // Only toggle if recipe is in private or approved state
            if ($recipe->status === 'private') {
                $recipe->status = 'approved';
            } elseif ($recipe->status === 'approved') {
                $recipe->status = 'private';
            } else {
                // If recipe is pending or rejected, don't allow toggle
                return response()->json([
                    'error' => 'Can only toggle between private and approved status'
                ], 422);
            }

            $recipe->save();

            // Return HTML fragment for Alpine.js x-target replacement
            return response()->view('admin.partials.recipe-status-badge', [
                'status' => $recipe->status
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to toggle recipe privacy'
            ], 422);
        }
    }
}
