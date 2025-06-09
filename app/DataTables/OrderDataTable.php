<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('shipping_price', function ($order) {
                return $order->shipping_price ? $order->shipping_price : '-';
            })
            ->editColumn('customer_id', function ($order) {
                return $order->customer_id ? $order->customer->first_name . ' ' . $order->customer->last_name : '-';
            })
            ->editColumn('status', function ($order) {
                return $order->status_label;
            })
            ->editColumn('tax_price', function ($order) {
                return $order->tax_price ? $order->tax_price : '-';
            })
            ->editColumn('total_price', function ($order) {
                return $order->total_price ? $order->total_price : '-';
            })
            ->editColumn('final_price', function ($order) {
                return $order->final_price ? $order->final_price : '-';
            })
            ->addColumn('created_at', function ($order) {
                if ($order->created_at) {
                    return Jalalian::fromCarbon($order->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($order) {
                if ($order->updated_at) {
                    return Jalalian::fromCarbon($order->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('action', function ($order) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('orders.preview', $order->customer_id) . '"><i class="bi bi-eye me-1"></i> نمایش</a></li>
                      <li><a class="dropdown-item" href="' . route('orders.edit', $order->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteOrder(' . $order->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
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
    public function query(Order $order): QueryBuilder
    {
        $query = $order->newQuery()->with('customer');

        $filters = session('order-filters', []);

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }
        if (!empty($filters['quantity'])) {
            $query->where('quantity', $filters['quantity']);
        }
        if (!empty($filters['total_price'])) {
            $query->where('total_price', $filters['total_price']);
        }
        if (!empty($filters['final_price'])) {
            $query->where('final_price', $filters['final_price']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }


        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('orders.datatable'))
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
            Column::make('id')->title('شناسه سفارش'),
            Column::make('customer_id')->title('کاربر'),
            Column::make('shipping_price')->title('هزینه پست'),
            Column::make('tax_price')->title('مالیات'),
            Column::make('total_price')->title('مبلغ کل'),
            Column::make('final_price')->title('مبلغ نهایی'),
            Column::make('quantity')->title('تعداد'),
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
        return 'Order_' . date('YmdHis');
    }
}
