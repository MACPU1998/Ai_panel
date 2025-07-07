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
            ->editColumn('wallet_id', function ($customer) {
                return $customer->wallet->balance ?? '-';
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

            ->addColumn('action', function ($customer) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('customers.edit', $customer->id) . '"><i class="bi bi-pencil me-1"></i>ویرایش مشتری</a></li>
                      <li><a class="dropdown-item" href="' . route('wallets.edit', $customer->id) . '"><i class="bi bi-pencil me-1"></i>ویرایش کیف پول</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteCustomer(' . $customer->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
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
    public function query(Customer $customer): QueryBuilder
    {
        $query = $customer->newQuery()->with(['country', 'state','city','wallet']);

        $filters = session('customer-filters', []);

        if (!empty($filters['first_name'])) {
            $query->where('first_name', $filters['first_name']);
        }

        if (!empty($filters['last_name'])) {
            $query->where('last_name', $filters['last_name']);
        }

        if (!empty($filters['phone'])) {
            $query->where('phone', $filters['phone']);
        }
        if (!empty($filters['national_id'])) {
            $query->where('national_id', $filters['national_id']);
        }

        if (!empty($filters['birth_date'])) {
            $query->where('birth_date', $filters['birth_date']);
        }

        if (!empty($filters['country_id'])) {
            $query->whereDate('country_id', $filters['country_id']);
        }
        if (!empty($filters['state_id'])) {
            $query->whereDate('state_id', $filters['state_id']);
        }
        if (!empty($filters['city_id'])) {
            $query->whereDate('city_id', $filters['city_id']);
        }

        return $query;
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
            Column::make('country_id')->title('کشور'),
            Column::make('state_id')->title('استان'),
            Column::make('city_id')->title('شهر'),
            Column::make('image')->title('عکس'),
            Column::make('wallet_id')->title('کیف پول'),
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
