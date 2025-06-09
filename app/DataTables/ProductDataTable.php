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
                return $media ? '<img src="' . $media . '" class="img-thumbnail" width="50">' : 'بدون تصویر';
            })
            ->rawColumns(['image', 'action'])
            ->editColumn('status', function ($product) {
                return $product->status == 1
                    ? 'فعال'
                    : 'غیرفعال';
            })
            ->editColumn('description', function ($product) {
                return $product->description ? $product->description : '-';
            })
            ->editColumn('final_price', function ($product) {
                return $product->final_price ? $product->final_price : '-';
            })
            ->editColumn('serial_prefix', function ($product) {
                return $product->serial_prefix ? $product->serial_prefix : '-';
            })
            ->editColumn('currency_id', function ($product) {
                return $product->currency_id ? $product->currency->slug : '-';
            })
            ->addColumn('created_at', function ($product) {
                if ($product->created_at) {
                    return Jalalian::fromCarbon($product->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($product) {
                if ($product->updated_at) {
                    return Jalalian::fromCarbon($product->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })

            ->addColumn('action', function ($product) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('products.edit', $product->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteProduct(' . $product->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
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
    public function query(Product $product): QueryBuilder
    {
        $query = $product->newQuery()->with(['currency']);

        $filters = session('product-filters', []);

        if (!empty($filters['name'])) {
            $query->where('name', $filters['name']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['currency_id'])) {
            $query->where('currency_id', $filters['currency_id']);
        }
       if (!empty($filters['serial_prefix'])) {
            $query->where('serial_prefix', $filters['serial_prefix']);
        }
        if (!empty($filters['price'])) {
            $query->where('price', $filters['price']);
        }
          if (!empty($filters['final_price'])) {
            $query->where('final_price', $filters['final_price']);
        }


        return $query;
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
            Column::make('serial_prefix')->title('شناسنه کالا'),
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
