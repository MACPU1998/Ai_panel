<?php

namespace App\DataTables;

use App\Models\SubProduct;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($subProduct) {
                return $subProduct->status == 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->editColumn('product_id', function ($subProduct) {
                return $subProduct->product_id ? $subProduct->product->name  : '-';
            })

            ->addColumn('created_at', function ($subProduct) {
                if ($subProduct->created_at) {
                    return Jalalian::fromCarbon($subProduct->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($subProduct) {
                if ($subProduct->updated_at) {
                    return Jalalian::fromCarbon($subProduct->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('action', function ($subProduct) {
                return '
                <a href="' . route('subProducts.edit', $subProduct->id) . '" class="btn btn-sm btn-primary"> <i class="bi bi-pencil"></i></a>
               <button class="btn btn-sm btn-danger" onclick="deleteSubProduct(' . $subProduct->id . ')"><i class="bi bi-trash"></i></button>
        ';
            })
            ->rawColumns(['image','action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SubProduct $subProduct): QueryBuilder
    {
        return $subProduct->newQuery()->with('product');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sub-products-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('subProducts.datatable')) // مسیر ajax
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
        Column::make('product_id')->title('نام محصول'),
        Column::make('barcode')->title('بارکد'),
        Column::make('serie_year')->title('سری سال'),
        Column::make('serie_month')->title('سری ماه'),
        Column::make('label')->title('لیبل'),
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
        return 'SubProducts_' . date('YmdHis');
    }
}
