<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('role', 'user')
                ->select('id', 'name', 'email','type' ,'city','short_bio','created_at','is_banned')
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch users'
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->role === 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin users cannot be deleted'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 500);
        }
    }
    public function ban($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin') {
                return response()->json([
                    'message' => 'Admin cannot be banned'
                ], 403);
            }

            $user->update(['is_banned' => true]);

            return response()->json([
                'success' => true,
                'message' => 'User banned successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to ban user'
            ], 500);
        }
    }

    public function unban($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update(['is_banned' => false]);

            return response()->json([
                'success' => true,
                'message' => 'User unbanned successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unban user'
            ], 500);
        }
    }

}
