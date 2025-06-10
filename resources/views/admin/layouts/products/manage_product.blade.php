@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  محصولات')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_product")}}</h5>
                <a href="{{route('products.create')}}" class="btn btn-primary mb-3">{{__("general.add_product")}}</a>

                <div class="accordion mb-4" id="filterAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="filterHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                فیلترها
                            </button>
                        </h2>
                        <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">

                <form id="filter-form" class="mb-4" method="GET" action="{{ route('products.index') }}">
                    <div class="row g-3">

                        <div class="col-md-2">
                            <label class="form-label">نام محصول</label>
                            <input type="text" class="form-control" name="name" value="{{ $filters['name'] ?? '' }}">
                        </div>


                        <div class="col-md-3">
                            <label class="form-label">ارز</label>
                            <select class="form-select" name="currency_id">
                                <option value="">همه ارزها</option>
                                @foreach(\App\Models\ProductCurrency::all() as $currency)
                                    <option value="{{ $currency->id }}" {{ ($filters['currency_id'] ?? '') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
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
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">شناسه کالا</label>
                            <input type="text" class="form-control" name="serial_prefix" value="{{ $filters['serial_prefix'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">مبلغ کل</label>
                            <input type="text" class="form-control" name="price" value="{{ $filters['price'] ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">مبلغ نهایی</label>
                            <input type="text" class="form-control" name="final_price" value="{{ $filters['final_price'] ?? '' }}">
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary">اعمال فیلتر</button>
                            <a href="{{ route('products.resetFilters') }}" class="btn btn-outline-danger ms-2">ریست</a>
                        </div>
                    </div>
                </form>

                            </div>
                        </div>
                    </div>
                </div>

                {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('products.datatable') }}',
                    data: function (d) {
                        d.barcode = $('input[name=name]').val();
                        d.status = $('select[name=status]').val();
                        d.warehouse_id = $('select[name=currency_id]').val();
                        d.production_date = $('input[name=serial_prefix]').val();
                        d.expiration_date = $('input[name=price]').val();
                        d.expiration_date = $('input[name=final_price]').val();
                    }
                },                stateSave: true,
                stateLoadParams: function (settings, data) {
                    if (data.start !== undefined) {
                        settings._iDisplayStart = data.start;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'name', name: 'name', render: function (data) {
                            if (data.length > 10) {
                                return `<span title="${data}">${data.substring(0, 10)}...</span>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'description', name: 'description', render: function (data) {
                            if (data.length > 10) {
                                return `<span title="${data}">${data.substring(0, 10)}...</span>`;
                            }
                            return data;
                        }
                    },
                    {data: 'status', name: 'status'},
                    {
                        data: 'image',
                        name: 'image',
                        searchable: false,
                        render: function (data) {
                            return data;
                        }
                    },
                    {data: 'currency_id', name: 'currency_id'},
                    {data: 'serial_prefix', name: 'serial_prefix'},
                    {data: 'price', name: 'price'},
                    {data: 'final_price', name: 'final_price'},
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
        function deleteProduct(productId) {
            if (confirm("آیا مطمئن هستید که می‌خواهید این محصول را حذف کنید؟")) {
                $.ajax({
                    url: '/admin/products/' + productId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(' با موفقیت حذف شد!');
                            $('#products-table').DataTable().ajax.reload();
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
