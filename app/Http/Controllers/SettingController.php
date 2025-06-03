<?php

namespace App\Http\Controllers;

use App\DataTables\SettingDataTable;
use App\Http\Requests\Setting\SettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.settings.manage_setting');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layouts.settings.add_setting');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {
        Setting::create($request->validated());
        return redirect()->route('settings.index')->with('success', 'تنظیمات با موفقیت ایجاد شد.');

    }

    public function getSettingsData(Request $request)
    {
        $setting = Setting::query();

        return DataTables::of($setting)
            ->addColumn('action', function ($setting) {
                return '<a href="' . route('settings.edit', $setting->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(SettingDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {

        return view('admin.layouts.settings.edit_setting', ['setting' => $setting]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->validated());
        return redirect()->route('settings.index')->with('success', 'تنظیمات با موفقیت ویرایش شد.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        try {
            $setting->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف تنظیمات'], 500);
        }
    }
}
