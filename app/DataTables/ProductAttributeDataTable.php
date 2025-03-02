<?php

namespace App\DataTables;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductAttributeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($productAttribute) {
                return $productAttribute->status == 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->addColumn('created_at', function ($productAttribute) {
                if ($productAttribute->created_at) {
                    return Jalalian::fromCarbon($productAttribute->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($productAttribute) {
                if ($productAttribute->updated_at) {
                    return Jalalian::fromCarbon($productAttribute->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })
            ->addColumn('action', function ($productAttribute) {
                return '
                <a href="' . route('productAttributes.edit', $productAttribute->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteProductAttribute(' . $productAttribute->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductAttribute $productAttribute): QueryBuilder
    {
        return $productAttribute->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-attributes-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('productAttributes.datatable')) // مسیر ajax
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
        Column::make('value')->title('مقدار'),
        Column::make('status')->title('وضعیت'),
        Column::make('product_id')->title('آی دی محصول'),
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
        return 'ProductAttributes_' . date('YmdHis');
    }
}
