@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  زیرمحصولات')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_sub_product")}}</h5>

                <div class="d-flex flex-column align-items-start mb-3">
                    <a href="{{ route('subProducts.create') }}" class="btn btn-success mb-2 w-auto">
                        {{ __("general.add_sub_product") }}
                    </a>
                    <a href="{{ route('subProducts.create.group') }}" class="btn btn-success w-auto">
                        {{ __("general.add_group_sub_product") }}
                    </a>
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
            $('#sub-products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('subProducts.datatable') }}',
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
