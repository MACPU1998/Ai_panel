@extends('admin.layouts.project-master-admin')

@section('title', 'مدیریت منوها')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_menu")}}</h5>
                <a href="{{route('menus.create')}}" class="btn btn-success mb-3">{{__("general.add_menu")}}</a>

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
            $('#menus-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('menus.datatable') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'icon', name: 'icon'},
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'link', name: 'link'},
                    {data: 'status', name: 'status'},
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
        function deleteMenu(menuId) {
            if (confirm("آیا مطمئن هستید که می‌خواهید این منو را حذف کنید؟")) {
                $.ajax({
                    url: '/admin/menus/' + menuId, // مسیر روت حذف منو
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('منو با موفقیت حذف شد!');

                            // حذف منو از سایدبار
                            $('#menu-item-' + menuId).remove();

                            // بعد از حذف، جدول دوباره بارگذاری می‌شود
                            $('#menus-table').DataTable().ajax.reload();
                        } else {
                            alert('خطا در حذف منو!');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('خطا در ارسال درخواست!');
                    }
                });
            }
        }

    </script>
@endsection
