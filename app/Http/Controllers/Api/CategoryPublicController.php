<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryPublicController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::select('id', 'name')
                ->orderBy('name')
                ->get()
                ->map(function ($cat) {
                    return [
                        'title' => $cat->name,
                        'forums' => [
                            [
                                'name' => 'General Discussion',
                                'threads' => 0,
                                'messages' => 0,
                                'lastPost' => 'No posts yet',
                                'user' => '-',
                                'time' => '-',
                            ]
                        ]
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load categories'
            ], 500);
        }
    }
}
