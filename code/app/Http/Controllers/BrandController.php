<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::withCount('cars');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('country') && $request->country != '') {
            $query->where('country', $request->country);
        }

        $brands = $query->latest()->paginate(10);

        // Lấy danh sách quốc gia thực tế từ DB (không null, không trùng)
        $countries = Brand::whereNotNull('country')
                          ->where('country', '!=', '')
                          ->distinct()
                          ->orderBy('country')
                          ->pluck('country');

        $totalBrands = Brand::count();
        $activeBrands = Brand::where('status', 'active')->count();
        $totalCars = \App\Models\Car::count();
        $newBrandsThisMonth = Brand::whereMonth('created_at', now()->month)->count();

        return view('admin.brands', compact('brands', 'countries', 'totalBrands', 'activeBrands', 'totalCars', 'newBrandsThisMonth'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'slug' => 'nullable|string|unique:brands,slug',
            'country' => 'nullable|string|max:100',
            'established_year' => 'nullable|integer',
            'website_url' => 'nullable|url',
            'logo_theme' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'nullable|string'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        if (empty($validated['status'])) {
            $validated['status'] = 'active';
        }

        if ($request->hasFile('logo_theme')) {
            $path = $request->file('logo_theme')->store('brands', 'public');
            $validated['logo_theme'] = '/storage/' . $path;
        }

        Brand::create($validated);
        return redirect()->route('brands.index')->with('success', 'Thêm hãng xe thành công!');
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'slug' => 'nullable|string|unique:brands,slug,' . $brand->id,
            'country' => 'nullable|string|max:100',
            'established_year' => 'nullable|integer',
            'website_url' => 'nullable|url',
            'logo_theme' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'nullable|string'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('logo_theme')) {
            $path = $request->file('logo_theme')->store('brands', 'public');
            $validated['logo_theme'] = '/storage/' . $path;
        }

        $brand->update($validated);
        return redirect()->route('brands.index')->with('success', 'Cập nhật hãng xe thành công!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Xóa hãng xe thành công!');
    }
}
