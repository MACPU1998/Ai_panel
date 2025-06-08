<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($customer) {
                $media = $customer->getFirstMediaUrl('customer_images');
                return $media ? '<img src="' . $media . '" class="img-thumbnail" width="50">' : 'بدون تصویر';
            })
            ->rawColumns(['image', 'action'])
            ->editColumn('national_id', function ($customer) {
                return $customer->national_id ? $customer->national_id : '-';
            })
            ->editColumn('birth_date', function ($customer) {
                return $customer->birth_date ? $customer->birth_date : '-';
            })
            ->editColumn('country_id', function ($customer) {
                return $customer->country->name ?? '-';
            })
            ->editColumn('state_id', function ($customer) {
                return $customer->state->name ?? '-';
            })
            ->editColumn('city_id', function ($customer) {
                return $customer->city->name ?? '-';
            })
            ->addColumn('created_at', function ($customer) {
                if ($customer->created_at) {
                    return Jalalian::fromCarbon($customer->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($customer) {
                if ($customer->updated_at) {
                    return Jalalian::fromCarbon($customer->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('wallet_amount', function ($customer) {
                return $customer->wallet ? number_format($customer->wallet->balance) . ' تومان' : '-';

            })


            ->addColumn('action', function ($customer) {
                return '
        <a href="' . route('customers.edit', $customer->id) . '" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil"></i>
        </a>

        <a href="' . route('wallet.edit', $customer->id) . '" class="btn btn-sm btn-warning mx-1" title="مدیریت کیف پول">
            <i class="bi bi-wallet2"></i>
        </a>

        <button class="btn btn-sm btn-danger" onclick="deleteCustomer(' . $customer->id . ')">
            <i class="bi bi-trash"></i>
        </button>
    ';
            })





            ->rawColumns(['image', 'action']) // برای تفسیر HTML در ستون action
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $customer): QueryBuilder
    {
        return $customer->newQuery()->with(['country', 'state', 'city', 'wallet']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('customers-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('customers.datatable'))
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
            Column::make('first_name')->title('نام'),
            Column::make('last_name')->title('نام خانوادگی'),
            Column::make('phone')->title('شماره همراه'),
            Column::make('national_id')->title('کد ملی'),
            Column::make('birth_date')->title('تاریخ تولد'),
//            Column::make('country_id')->title('کشور'),
//            Column::make('state_id')->title('استان'),
            Column::make('city_id')->title('شهر'),
            Column::make('wallet_id')->title('کیف پول'),
            Column::make('wallet_amount')->title('موجودی کیف پول'),
            Column::make('image')->title('عکس'),
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
        return 'Customer_' . date('YmdHis');
    }
}
