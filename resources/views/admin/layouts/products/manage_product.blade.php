@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  محصولات')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_product")}}</h5>
                <a href="{{route('products.create')}}" class="btn btn-success mb-3">{{__("general.add_product")}}</a>

                {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
            </div>
        </div>
    </div>


    <!-- جاوا اسکریپت های مورد نیاز Bootstrap و DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.datatable') }}',
                stateSave: true,
                stateLoadParams: function (settings, data) {
                    if (data.start !== undefined) {
                        settings._iDisplayStart = data.start;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'name', name: 'name', render: function (data, type, row) {
                            if (data.length > 10) { // اگر طول لینک بیشتر از 10 باشد، کوتاه کن
                                return `<span title="${data}">${data.substring(0, 10)}...</span>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'description', name: 'description', render: function (data, type, row) {
                            if (data.length > 10) { // اگر طول لینک بیشتر از 10 باشد، کوتاه کن
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
                        render: function (data, type, row) {
                            return data; // مقدار HTML که از سرور ارسال شده است نمایش داده می‌شود
                        }
                    },
                    {data: 'currency_id', name: 'currency_id'},
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
                            // بعد از حذف، جدول دوباره بارگذاری می‌شود
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
