@extends('admin.layouts.project-master-admin')

@section('title', 'لیست نقش ها')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">

                <form action="{{ route('roles.assign') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="role" class="form-label">نقش فعلی: </label>
                        <span class="fw-bold">{{ $roles->name }}</span> <!-- نمایش نام نقش انتخاب شده -->
                        <input type="hidden" name="role_id" value="{{ $roles->id }}"> <!-- ارسال آیدی نقش -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label">انتخاب مجوزها:</label>
                        <div class="d-flex flex-column gap-2">
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                           value="{{ $permission->id }}" {{$roles->hasPermissionTo($permission->name)?"checked":""}} id="perm-{{ $permission->id }}">
                                    <label class="form-check-label" for="perm-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- نمایش مجوزهای انتخاب‌شده -->
                    <div class="mt-3">
                        <label class="form-label">مجوزهای انتخاب‌شده:</label>
                        <div id="selected-permissions" class="d-flex flex-wrap gap-2 my-3"></div> <!-- نمایش به صورت افقی -->
                    </div>


                    <button type="submit" class="btn btn-success">{{__("general.submit_btn")}}</button>
                </form>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        function updateSelectedPermissions() {
                            let selected = [];
                            $(".permission-checkbox:checked").each(function() {
                                selected.push($(this).next("label").text()); // دریافت نام مجوز انتخاب‌شده
                            });

                            let list = $("#selected-permissions");
                            list.empty(); // لیست را خالی کن
                            if (selected.length > 0) {
                                selected.forEach(function(name) {
                                    list.append(`<span class="badge bg-light text-dark p-2 border ">${name}</span>`); // نمایش در یک خط
                                });
                            } else {
                                list.append(`<span class="text-muted">هیچ مجوزی انتخاب نشده</span>`);
                            }
                        }

                        // اجرای تابع هنگام تغییر در چک‌باکس‌ها
                        $(".permission-checkbox").on("change", updateSelectedPermissions);

                        // نمایش مقدارهای تیک خورده در بارگذاری اولیه صفحه
                        updateSelectedPermissions();
                    });
                </script>



            </div>
        </div>
    </div>

@endsection
