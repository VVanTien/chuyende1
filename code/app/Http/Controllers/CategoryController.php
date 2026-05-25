<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('cars');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(10);
        
        $totalCategories = Category::count();
        $activeCategories = Category::where('status', 'active')->count();

        // Count top categories
        // Just for demo statistics
        $totalCars = \App\Models\Car::count();
        $inactiveCategories = Category::where('status', 'inactive')->count();

        return view('admin.categories', compact('categories', 'totalCategories', 'activeCategories', 'totalCars', 'inactiveCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        if (empty($validated['status'])) {
            $validated['status'] = 'active';
        }

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Thêm dòng xe thành công!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Cập nhật dòng xe thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa dòng xe thành công!');
    }
}
