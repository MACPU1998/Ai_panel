<?php

namespace App\DataTables;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WarehousesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->editColumn('name', function ($warehouses) {
                return $warehouses->name ? $warehouses->name : '-';
            })
            ->editColumn('address', function ($warehouses) {
                return $warehouses->address ? $warehouses->address : '-';
            })
            ->editColumn('status', function ($warehouse) {
                return (int) $warehouse->status === 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->editColumn('make_default', function ($warehouse) {
                return (int) $warehouse->make_default === 1
                    ? 'بله'
                    : 'خیر';
            })
            ->addColumn('created_at', function ($warehouses) {
                if ($warehouses->created_at) {
                    return Jalalian::fromCarbon($warehouses->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($warehouses) {
                if ($warehouses->updated_at) {
                    return Jalalian::fromCarbon($warehouses->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('action', function ($warehouses) {
                return '
                <a href="' . route('warehouses.edit', $warehouses->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteWarehouse(' . $warehouses->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['image', 'action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Warehouse $warehouse): QueryBuilder
    {
        return $warehouse->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('warehouses-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('warehouses.datatable'))
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
            Column::make('name')->title('نام'),
            Column::make('address')->title('آدرس'),
            Column::make('status')->title('وضعیت'),
            Column::make('make_default')->title('انبار پیشفرض'),
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
        return 'Warehouse_' . date('YmdHis');
    }
}
