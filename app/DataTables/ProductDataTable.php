<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($product) {
                $media = $product->getFirstMediaUrl('product_images');
                return $media ? '<img src="'.$media.'" class="img-thumbnail" width="50">' : 'بدون تصویر';
            })
            ->rawColumns(['image', 'action'])
            ->editColumn('status', function ($product) {
                return $product->status == 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->editColumn('currency_id', function ($product) {
                return $product->currency_id ? $product->currency->slug : '-';
            })
            ->addColumn('created_at', function ($product) {
                if ($product->created_at) {
                    return Jalalian::fromCarbon($product->created_at)->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($product) {
                if ($product->updated_at) {
                    return Jalalian::fromCarbon($product->updated_at)->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })
            ->addColumn('action', function ($product) {
                return '
                <a href="' . route('products.edit', $product->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteProduct(' . $product->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['image','action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $product): QueryBuilder
    {
        return $product->newQuery()->with('currency');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('products.datatable')) // مسیر ajax
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
        Column::make('description')->title('توضیحات'),
        Column::make('status')->title('وضعیت'),
        Column::make('image')->title('عکس'),
        Column::make('currency_id')->title('ارز'),
        Column::make('price')->title('قیمت'),
        Column::make('final_price')->title('قیمت نهایی'),
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
        return 'Product_' . date('YmdHis');
    }
}
