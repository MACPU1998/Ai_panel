<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
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
        return $dataTable->render('admin.layouts.categories.manage_category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layouts.categories.add_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success', 'دسته بندی با موفقیت ایجاد شد.');

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

        return view('admin.layouts.categories.edit_category', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success', 'دسته بندی با موفقیت ویرایش شد.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->product_categories()->exists()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'این دسته بندی در دسته بندی محصولات استفاده شده و قابل حذف نیست'
                ], 400
            );
        }

        try {
            $category->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف دسته بندی'], 500);
        }
    }
}
