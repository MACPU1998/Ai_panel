<?php

namespace App\DataTables;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WalletDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('customer_id', function ($wallet) {
                return $wallet->customer_id ? $wallet->customer->first_name . ' ' . $wallet->customer->last_name : '';
            })
            ->addColumn('created_at', function ($wallet) {
                if ($wallet->created_at) {
                    return Jalalian::fromCarbon($wallet->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($wallet) {
                if ($wallet->updated_at) {
                    return Jalalian::fromCarbon($wallet->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })

            ->addColumn('action', function ($wallet) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('wallets.edit', $wallet->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteWallet(' . $wallet->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
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
    public function query(Wallet $wallet): QueryBuilder
    {
        return $wallet->newQuery()->with(['customer']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('wallets-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('wallets.datatable')) // مسیر ajax
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
        Column::make('customer_id')->title('مشتری'),
        Column::make('balance')->title('مقدار'),
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
        return 'Wallets_' . date('YmdHis');
    }
}
