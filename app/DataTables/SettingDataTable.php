<?php

namespace App\DataTables;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SettingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('created_at', function ($setting) {
                if ($setting->created_at) {
                    return Jalalian::fromCarbon($setting->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($setting) {
                if ($setting->updated_at) {
                    return Jalalian::fromCarbon($setting->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('action', function ($setting) {
                return '
                <a href="' . route('settings.edit', $setting->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteSetting(' . $setting->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Setting $setting): QueryBuilder
    {
        return $setting->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('settings-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('settings.datatable')) // مسیر ajax
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
        Column::make('key')->title('نام'),
        Column::make('value')->title('مقدار'),
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
        return 'Settings_' . date('YmdHis');
    }
}
