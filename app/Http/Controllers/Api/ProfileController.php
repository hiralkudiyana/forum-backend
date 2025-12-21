<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // GET profile
    public function show(Request $request)
    {
        try {
            return response()->json([
                'user' => $request->user()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch profile'
            ], 500);
        }
    }

    // UPDATE profile
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|in:Role A,Role B,Role C',
                'city' => 'nullable|string|max:100',
                'short_bio' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();
            $user->update([
                'name' => $request->name,
                'type' => $request->role,
                'city' => $request->city,
                'short_bio' => $request->short_bio,
            ]);

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Profile update failed'
            ], 500);
        }
    }

}
