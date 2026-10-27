@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  سفارشات')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_order")}}</h5>
                <a href="{{route('orders.create')}}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{__("general.add_order")}}</a>


                <div class="accordion mb-4" id="filterAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="filterHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                فیلترها
                            </button>
                        </h2>
                        <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">

                                <form id="filter-form" class="mb-4" method="GET" action="{{ route('orders.index') }}">
                                    <div class="row g-3">

                                        <div class="col-md-3">
                                            <label class="form-label">مشتریان</label>
                                            <select class="form-select" name="customer_id">
                                                <option value="">همه مشتریان</option>
                                                @foreach(\App\Models\Customer::all() as $customer)
                                                    <option value="{{ $customer->id }}" {{ ($filters['customer_id'] ?? '') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">تعداد</label>
                                            <input type="text" class="form-control" name="quantity" value="{{ $filters['quantity'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">مبلغ کل</label>
                                            <input type="text" class="form-control" name="total_price" value="{{ $filters['total_price'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">مبلغ نهایی</label>
                                            <input type="text" class="form-control" name="final_price" value="{{ $filters['final_price'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">وضعیت</label>
                                            <select class="form-select" name="status">
                                                <option value="">همه وضعیت</option>
                                                <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>لغو شده</option>
                                                <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>سبد خرید</option>
                                                <option value="2" {{ ($filters['status'] ?? '') === '2' ? 'selected' : '' }}>پرداخت شده</option>
                                                <option value="3" {{ ($filters['status'] ?? '') === '3' ? 'selected' : '' }}>تایید ادمین</option>
                                                <option value="4" {{ ($filters['status'] ?? '') === '4' ? 'selected' : '' }}>در حال پردازش</option>
                                                <option value="5" {{ ($filters['status'] ?? '') === '5' ? 'selected' : '' }}>آماده ارسال</option>
                                                <option value="6" {{ ($filters['status'] ?? '') === '6' ? 'selected' : '' }}>ارسال شده</option>
                                            </select>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-outline-primary">اعمال فیلتر</button>
                                            <a href="{{ route('orders.resetFilters') }}" class="btn btn-outline-danger ms-2">ریست</a>
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
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('orders.datatable') }}',
                    data: function (d) {
                        d.product_id = $('select[name=customer_id]').val();
                        d.barcode = $('input[name=quantity]').val();
                        d.serie_year = $('input[name=total_price]').val();
                        d.serie_month = $('input[name=final_price]').val();
                        d.status = $('select[name=status]').val();
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
                    { data: 'customer_name', name: 'customer_name', title: 'مشتری' },
                    {  data: 'shipping_price', name: 'shipping_price'},
                    {  data: 'tax_price', name: 'tax_price'},
                    {  data: 'total_price', name: 'total_price'},
                    {  data: 'final_price', name: 'final_price'},
                    {  data: 'quantity', name: 'quantity'},
                    {  data: 'status', name: 'status'},
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
        function deleteOrder(orderId) {
            if (confirm("آیا مطمئن هستید که می‌خواهید این سفارش را حذف کنید؟")) {
                $.ajax({
                    url: '/admin/orders/' + orderId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(' با موفقیت حذف شد!');
                            $('#orders-table').DataTable().ajax.reload();
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
