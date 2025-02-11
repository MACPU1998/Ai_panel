<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.categories.manage-category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layouts.categories.add-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'status' => 'required',
        ]);
        Category::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('categories.index')->with('success', 'کاربر با موفقیت ایجاد شد.');

    }

    public function getCategoryData(Request $request)
    {
        $category = Category::query();

        return DataTables::of($category)
            ->addColumn('action', function ($category) {
                return '<a href="' . route('categories.edit', $category->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(CategoriesDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        return view('admin.layouts.categories.edit-category', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'status' => 'required',
        ]);
        $category->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('categories.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف دسته بندی'], 500);
        }
    }
}
