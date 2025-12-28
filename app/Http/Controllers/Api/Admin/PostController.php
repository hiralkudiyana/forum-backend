<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // List posts
    public function index()
    {
        $posts = Post::with('category:id,name')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    // Store post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        Post::create([
            'title' => $request->title,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post added successfully'
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->only('title', 'category_id'));

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully'
        ]);
    }

    // 🗑 Delete Post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
}
