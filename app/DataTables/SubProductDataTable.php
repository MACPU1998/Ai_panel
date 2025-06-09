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
                return $subProduct->product_id ? $subProduct->product->name : '-';
            })
            ->editColumn('warehouse_id', function ($subProduct) {
                return $subProduct->warehouse_id ? $subProduct->warehouse->name : '-';
            })
            ->editColumn('production_date', function ($subProduct) {
                return $subProduct->production_date ?? '-';
            })
            ->editColumn('expiration_date', function ($subProduct) {
                return $subProduct->expiration_date ?? '-';
            })
            ->editColumn('created_at', function ($subProduct) {
                if ($subProduct->created_at) {
                    return Jalalian::fromCarbon($subProduct->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->editColumn('updated_at', function ($subProduct) {
                if ($subProduct->updated_at) {
                    return Jalalian::fromCarbon($subProduct->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })

            ->addColumn('action', function ($subProduct) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('subProducts.edit', $subProduct->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteSubProduct(' . $subProduct->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
                  </ul>
             </div>
    ';
            })

            ->rawColumns(['image', 'action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SubProduct $subProduct): QueryBuilder
    {
        $query = $subProduct->newQuery()->with(['product', 'warehouse']);

        $filters = session('sub-product-filters', []);

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }
        if (!empty($filters['barcode'])) {
            $query->where('barcode', 'like', '%' . $filters['barcode'] . '%');
        }
        if (!empty($filters['serie_year'])) {
            $query->where('serie_year', $filters['serie_year']);
        }
        if (!empty($filters['serie_month'])) {
            $query->where('serie_month', $filters['serie_month']);
        }
        if (!empty($filters['label'])) {
            $query->where('label', 'like', '%' . $filters['label'] . '%');
        }
        if (!empty($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['production_date'])) {
            $query->whereDate('production_date', $filters['production_date']);
        }
        if (!empty($filters['expiration_date'])) {
            $query->whereDate('expiration_date', $filters['expiration_date']);
        }

        return $query;
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
            Column::make('warehouse_id')->title('انبار'),
            Column::make('status')->title('وضعیت'),
            Column::make('production_date')->title('تاریخ تولید'),
            Column::make('expiration_date')->title('تاریخ انقضا'),
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
