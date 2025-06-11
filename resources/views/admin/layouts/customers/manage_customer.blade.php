@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت  مشتری')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8 my-10">
                <h5 class="mb-4">{{__("general.manage_customer")}}</h5>
                <a href="{{route('customers.create')}}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{__("general.add_customer")}}</a>


                <div class="accordion mb-4" id="filterAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="filterHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                فیلترها
                            </button>
                        </h2>
                        <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">

                                <form id="filter-form" class="mb-4" method="GET" action="{{ route('customers.index') }}">
                                    <div class="row g-3">

                                        <div class="col-md-2">
                                            <label class="form-label">نام</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $filters['first_name'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">نام خانوادگی</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $filters['last_name'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">تلفن همراه</label>
                                            <input type="text" class="form-control" name="phone" value="{{ $filters['phone'] ?? '' }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">کد ملی</label>
                                            <input type="text" class="form-control" name="national_id" value="{{ $filters['national_id'] ?? '' }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">کشور</label>
                                            <select class="form-select" name="country_id">
                                                <option value="">همه کشورها</option>
                                                @foreach(\App\Models\Country::all() as $country)
                                                    <option value="{{ $country->id }}" {{ ($filters['country_id'] ?? '') == $country->id ? 'selected' : '' }}>

                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">استان</label>
                                            <select class="form-select" name="state_id">
                                                <option value="">همه استان ها</option>
                                                @foreach(\App\Models\City::all() as $state)
                                                    <option value="{{ $state->id }}" {{ ($filters['state_id'] ?? '') == $state->id ? 'selected' : '' }}>

                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">شهر</label>
                                            <select class="form-select" name="city_id">
                                                <option value="">همه شهرها</option>
                                                @foreach(\App\Models\City::all() as $city)
                                                    <option value="{{ $city->id }}" {{ ($filters['city_id'] ?? '') == $city->id ? 'selected' : '' }}>

                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">تاریخ تولد</label>
                                            <input type="date" class="form-control" name="birth_date" value="{{ $filters['birth_date'] ?? '' }}">
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-outline-primary">اعمال فیلتر</button>
                                            <a href="{{ route('customers.resetFilters') }}" class="btn btn-outline-danger ms-2">ریست</a>
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
            $('#customers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('customers.datatable') }}',
                    data: function (d) {
                        d.first_name = $('select[name=first_name]').val();
                        d.last_name = $('input[name=last_name]').val();
                        d.phone = $('input[name=phone]').val();
                        d.national_id = $('input[name=national_id]').val();
                        d.birth_date = $('input[name=birth_date]').val();
                        d.country_id = $('select[name=country_id]').val();
                        d.state_id = $('select[name=state_id]').val();
                        d.city_id = $('select[name=city_id]').val();

                    }
                },                stateSave: true,
                stateLoadParams: function (settings, data) {
                    if (data.start !== undefined) {
                        settings._iDisplayStart = data.start;
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},

                    {  data: 'first_name', name: 'first_name'},
                    {  data: 'last_name', name: 'last_name'},
                    {  data: 'phone', name: 'phone'},
                    {  data: 'national_id', name: 'national_id'},
                    {  data: 'birth_date', name: 'birth_date'},
                    {  data: 'country_id', name: 'country_id'},
                    {  data: 'state_id', name: 'state_id'},
                    {  data: 'city_id', name: 'city_id'},
                    {
                        data: 'image',
                        name: 'image',
                        searchable: false,
                        render: function (data) {
                            return data;
                        }
                    },
                    {data: 'wallet_id', name: 'wallet_id'},
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
        function deleteCustomer(customerId) {
            if (confirm("آیا مطمئن هستید که می‌خواهید این مشتری را حذف کنید؟")) {
                $.ajax({
                    url: '/admin/customers/' + customerId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(' با موفقیت حذف شد!');
                            $('#customers-table').DataTable().ajax.reload();
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
