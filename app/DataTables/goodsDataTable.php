<?php

namespace App\DataTables;

use App\Models\Goods;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class goodsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($goods) {
                return $goods->status == 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->editColumn('product_id', function ($goods) {
                return $goods->product_id ? $goods->product->name  : '-';
            })
            ->addColumn('created_at', function ($goods) {
                if ($goods->created_at) {
                    return Jalalian::fromCarbon($goods->created_at)->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($goods) {
                if ($goods->updated_at) {
                    return Jalalian::fromCarbon($goods->updated_at)->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })
            ->addColumn('action', function ($goods) {
                return '
                <a href="' . route('goods.edit', $goods->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteGoods(' . $goods->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Goods $goods): QueryBuilder
    {
        return $goods->newQuery()->with('product'); // اضافه کردن رابطه محصول
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('goods-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('goods.datatable')) // مسیر ajax
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
            Column::make('product_id')->title('کد محصول'),
            Column::make('barcode')->title('بارکد'),
            Column::make('serial_date')->title('تاریخ سری'),
            Column::make('version')->title('نسخه'),
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
        return 'Goods_' . date('YmdHis');
    }
}
