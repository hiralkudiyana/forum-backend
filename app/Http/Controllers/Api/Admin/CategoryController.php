<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List categories
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Category::orderBy('id', 'desc')->get()
        ]);
    }

    // Add category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created',
            'data' => $category
        ], 201);
    }

    // Delete category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted'
        ]);
    }
}
