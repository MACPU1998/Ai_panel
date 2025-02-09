<?php

namespace App\Http\Controllers;

use App\DataTables\MenusDataTable;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(MenusDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.menu-data-tables.manage-menu');
    }

    public function create()
    {
        $menus = Menu::all();
        return view('admin.layouts.menu-data-tables.add-menu', compact('menus'));
    }

    public function store(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'link' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
        Menu::create([
            'title' => $request->title,
            'icon' => $request->icon ?: '#',
            'parent_id' => $request->parent_id ?: null,
            'link' => $request->link ?: '#',
            'status' => (int)$request->status,
        ]);
        return redirect('admin/menus')->with('success', 'منو با موفقیت اضافه شد');
    }

    public function getMenuData(Request $request)
    {
        $menu = Menu::query();

        return DataTables::of($menu)
            ->addColumn('action', function ($menu) {
                return '<a href="' . route('permissions.edit', $menu->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(MenusDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Menu $menu)
    {
        $menus = Menu::all();
        return view('admin.layouts.menu-data-tables.edit-menu', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'link' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
        $menu->update([
            'title' => $validated['title'],
            'icon' => $validated['icon'] ?? '#',
            'parent_id' => $validated['parent_id'] ?: null, // مقدار null را به‌درستی ذخیره می‌کند
            'link' => $validated['link'] ?? '#',
            'status' => $validated['status'],
        ]);
        return redirect()->route('menus.index')->with('success', 'منو با موفقیت ویرایش شد.');
    }

    public function destroy(Menu $menu)
    {
        try {
            $menu->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف منو'], 500);
        }
    }

}
