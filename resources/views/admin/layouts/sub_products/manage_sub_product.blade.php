@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  زیرمحصولات')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_sub_product")}}</h5>


                <div class="d-flex flex-row flex-wrap align-items-center mb-3 gap-2">
                    <a href="{{ route('subProducts.create') }}" class="btn btn-primary w-auto">
                        <i class="bi bi-plus-lg me-1"></i>
                        {{ __("general.add_sub_product") }}
                    </a>

                    <a href="{{ route('subProducts.create.group') }}" class="btn btn-primary w-auto">
                        <i class="bi bi-plus-lg me-1"></i>
                        {{ __("general.add_group_sub_product") }}
                    </a>

                    <a href="{{ route('subProducts.create.excel') }}" class="btn btn-primary w-auto">
                        <i class="bi bi-plus-lg me-1"></i>
                        {{ __("general.add_excel_sub_product") }}
                    </a>
                </div>


                <div class="accordion mb-4" id="filterAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="filterHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                فیلترها
                            </button>
                        </h2>
                        <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">

                <form id="filter-form" class="mb-4" method="GET" action="{{ route('subProducts.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">نام محصول</label>
                            <select class="form-select" name="product_id">
                                <option value="">همه محصولات</option>
                                @foreach(\App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}" {{ ($filters['product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">بارکد</label>
                            <input type="text" class="form-control" name="barcode" value="{{ $filters['barcode'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">سری سال</label>
                            <input type="text" class="form-control" name="serie_year"  value="{{ $filters['serie_year'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">سری ماه</label>
                            <input type="text" class="form-control" name="serie_month" value="{{ $filters['serie_month'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">لیبل</label>
                            <input type="text" class="form-control" name="label" value="{{ $filters['label'] ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">انبار</label>
                            <select class="form-select" name="warehouse_id">
                                <option value="">همه انبارها</option>
                                @foreach(\App\Models\Warehouse::all() as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ ($filters['warehouse_id'] ?? '') == $warehouse->id ? 'selected' : '' }}>

                                    {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">وضعیت</label>
                            <select class="form-select" name="status">
                                <option value="">همه وضعیت</option>
                                <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>غیرفعال</option>
                                <option value="2" {{ ($filters['status'] ?? '') === '2' ? 'selected' : '' }}>مرجوعی</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">تاریخ تولید</label>
                            <input type="date" class="form-control" name="production_date" id="production_date  " value="{{ $filters['production_date'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">تاریخ انقضا</label>
                            <input type="date" class="form-control" name="expiration_date" id="expiration_date" value="{{ $filters['expiration_date'] ?? '' }}">
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary">اعمال فیلتر</button>
                            <a href="{{ route('subProducts.resetFilters') }}" class="btn btn-outline-danger ms-2">ریست</a>
                        </div>
                    </div>
                </form>

                            </div>
                        </div>
                    </div>
                </div>

                {{ $dataTable->table(['id' => 'sub-products-table', 'class' => 'table table-striped table-bordered ']) }}

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#sub-products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('subProducts.datatable') }}',
                    data: function (d) {
                        d.product_id = $('select[name=product_id]').val();
                        d.barcode = $('input[name=barcode]').val();
                        d.serie_year = $('input[name=serie_year]').val();
                        d.serie_month = $('input[name=serie_month]').val();
                        d.label = $('input[name=label]').val();
                        d.warehouse_id = $('select[name=warehouse_id]').val();
                        d.status = $('select[name=status]').val();
                        d.production_date = $('input[name=production_date]').val();
                        d.expiration_date = $('input[name=expiration_date]').val();
                    }
                },
                stateSave: true,
                stateLoadParams: function (settings, data) {
                    if (data.start !== undefined) {
                        settings._iDisplayStart = data.start;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'product_id', name: 'product_id'},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'serie_year', name: 'serie_year'},
                    {data: 'serie_month', name: 'serie_month'},
                    {data: 'label', name: 'label'},
                    {data: 'warehouse_id', name: 'warehouse_id'},
                    {data: 'status', name: 'status'},
                    {data: 'production_date', name: 'production_date'},
                    {data: 'expiration_date', name: 'expiration_date'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                language: {
                    "sProcessing": "در حال پردازش...",
                    "sLengthMenu": "نمایش _MENU_ رکورد",
                    "sZeroRecords": "موردی پیدا نشد",
                    "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    "sInfoEmpty": "نمایش 0 تا 0 از 0 رکورد",
                    "sInfoFiltered": "(فیلتر شده از _MAX_ رکورد)",
                    "sInfoPostFix": "",
                    "sSearch": "جستجو: ",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "در حال بارگذاری...",
                    "oPaginate": {
                        "sFirst": "اولین",
                        "sPrevious": "قبلی",
                        "sNext": "بعدی",
                        "sLast": "آخرین"
                    },
                    "oAria": {
                        "sSortAscending": ": فعال سازی برای مرتب‌سازی صعودی",
                        "sSortDescending": ": فعال سازی برای مرتب‌سازی نزولی"
                    }
                }
            });
        });
    </script>

    <script>
        function deleteSubProduct(subProductId) {
            if (confirm("آیا مطمئن هستید که می‌خواهید این زیرمحصول را حذف کنید؟")) {
                $.ajax({
                    url: '/admin/sub-products/' + subProductId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(' با موفقیت حذف شد!');
                            $('#sub-products-table').DataTable().ajax.reload();
                        } else {
                            alert('خطا در حذف !');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        alert('خطا در ارسال درخواست!');
                    }
                });
            }
        }
    </script>
@endsection
