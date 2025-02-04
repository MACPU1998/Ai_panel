<?php

namespace App\DataTables;

use App\Models\Admin\Menu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MenusDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('created_at', function ($menu) {
                if ($menu->created_at) {
                    return Jalalian::fromCarbon($menu->created_at)->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($menu) {
                if ($menu->updated_at) {
                    return Jalalian::fromCarbon($menu->updated_at)->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })
            ->addColumn('action', function ($menu) {
                return '<div class="d-flex gap-1">
                <a href="' . route('menus.edit', $menu->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteMenu(' . $menu->id . ')"><i class="bi bi-trash"></i></button>
               </div>
        ';
            })
            ->rawColumns(['action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Menu $menu): QueryBuilder
    {
        return $menu->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menus-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('menus.datatable')) // مسیر ajax
            ->orderBy(0)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', 'reload'],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
    return [
        Column::make('id')->title('شناسه'),
        Column::make('title')->title('عنوان'),
        Column::make('icon')->title('آیکون'),
        Column::make('parent_id')->title('آی دی والد'),
        Column::make('link')->title('لینک'),
        Column::make('status')->title('وضعیت'),
        Column::make('created_at')->title('تاریخ ایجاد'),
        Column::make('updated_at')->title('تاریخ آپدیت'),
        Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->addClass('text-center')
            ->title('عملیات'),
    ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Menus_' . date('YmdHis');
    }
}
