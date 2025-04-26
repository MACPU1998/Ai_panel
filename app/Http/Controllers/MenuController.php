<?php

namespace App\Http\Controllers;

use App\DataTables\MenusDataTable;
use App\Http\Requests\MenuRequest;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(MenusDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.menu_data_tables.manage_menu');
    }

    public function create()
    {
        $menus = Menu::all();
        return view('admin.layouts.menu_data_tables.add_menu', compact('menus'));
    }

    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());
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
        return view('admin.layouts.menu_data_tables.edit_menu', compact('menu', 'menus'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
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
