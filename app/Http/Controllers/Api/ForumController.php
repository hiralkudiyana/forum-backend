<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class ForumController extends Controller
{
    public function categoriesWithPosts()
    {
        $categories = Category::with(['posts:id,title,category_id'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
