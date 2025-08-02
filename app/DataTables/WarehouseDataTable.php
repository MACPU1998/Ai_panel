<?php

namespace App\DataTables;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WarehouseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($warehouse) {
                return $warehouse->status_label;
            })
            ->editColumn('address', function ($warehouse) {
                return $warehouse->address ?? '-';
            })
            ->editColumn('description', function ($warehouse) {
                return $warehouse->description ?? '-';

            })
            ->editColumn('make_default', function ($warehouse) {
                return $warehouse->make_default == 1 ? 'انبار پیش فرض' : '-';
            })
            ->editColumn('count_of_SP', function ($warehouse) {
                return $warehouse->subProducts->count() ?? '-';
            })
            ->addColumn('created_at', function ($warehouse) {
                if ($warehouse->created_at) {
                    return Jalalian::fromCarbon($warehouse->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($warehouse) {
                if ($warehouse->updated_at) {
                    return Jalalian::fromCarbon($warehouse->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })
            ->addColumn('action', function ($warehouse) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('warehouses.edit', $warehouse->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="' . route('warehouses.show', $warehouse->id) . '"><i class="bi bi-pencil me-1"></i> لیست زیر محصول</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteWarehouse(' . $warehouse->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
                  </ul>
             </div>
    ';
            })
            ->rawColumns(['action']) // برای تفسیر HTML در ستون action
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
            ->minifiedAjax(route('warehouses.datatable')) // مسیر ajax
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
            Column::make('description')->title('توضیحات'),
            Column::make('make_default')->title('پیش فرض'),
            Column::make('count_of_SP')->title('تعداد اقلام'),
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
        return 'Warehouses_' . date('YmdHis');
    }
}
