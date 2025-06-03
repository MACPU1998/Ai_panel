<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Morilog\Jalali\Jalalian;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('created_at', function ($role) {
                if ($role->created_at) {
                    return Jalalian::fromCarbon($role->created_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-';
            })
            ->addColumn('updated_at', function ($role) {
                if ($role->updated_at) {
                    return Jalalian::fromCarbon($role->updated_at->setTimezone('Asia/Tehran'))->format('Y/m/d - H:i');
                }
                return '-'; // مقدار پیش‌فرض برای زمانی که updated_at خالی باشد
            })

            ->addColumn('action', function ($role) {
                return '
            <div class="dropdown text-center">
               <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
              </button>
                   <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="' . route('roles.edit', $role->id) . '"><i class="bi bi-pencil me-1"></i> ویرایش</a></li>
                      <li><a class="dropdown-item" href="' . route('roles.list', $role->id) . '"><i class=" bi bi-box2 me-1"></i> دسترسی</a></li>
                      <li><a class="dropdown-item" href="#" onclick="deleteRole(' . $role->id . ')"><i class="bi bi-trash me-1 text-danger"></i> حذف</a></li>
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
    public function query(Role $role): QueryBuilder
    {
        return $role->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roles-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('roles.datatable')) // مسیر ajax
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
        Column::make('guard_name')->title('نام گارد'),
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
        return 'Roles_' . date('YmdHis');
    }
}
