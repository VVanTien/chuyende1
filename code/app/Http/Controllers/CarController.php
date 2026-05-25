<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'category']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('vin_code', 'like', "%{$search}%");
            });
        }
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate(10);
        $brands = Brand::all();
        $categories = Category::all();

        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $rentedCars = Car::where('status', 'rented')->count();
        $maintenanceCars = Car::where('status', 'maintenance')->count();

        return view('admin.cars', compact('cars', 'brands', 'categories', 'totalCars', 'availableCars', 'rentedCars', 'maintenanceCars'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'vin_code' => 'required|string|unique:cars,vin_code',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'sale_price' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean'
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'available';
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('cars', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        Car::create($validated);
        return redirect()->route('cars.index')->with('success', 'Thêm xe thành công!');
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'vin_code' => 'required|string|unique:cars,vin_code,' . $car->id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'sale_price' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean'
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('cars', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $car->update($validated);
        return redirect()->route('cars.index')->with('success', 'Cập nhật xe thành công!');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Xóa xe thành công!');
    }
}
