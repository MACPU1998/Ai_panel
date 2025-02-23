@extends('admin.layouts.project_master_admin')

@section('title', 'لیست نقش ها')

@section('content')

    <div class="col-lg-12">
        <div class="card ">
            <div class="container mt-8 ">

                <form action="{{ route('roles.assign') }}" method="POST" class="my-10 mx-2">
                    @csrf

                    <div class="mb-3">
                        <label for="role" class="form-label">{{__("general.current_role")}}</label>
                        <span class="fw-bold">{{ $roles->name }}</span> <!-- نمایش نام نقش انتخاب شده -->
                        <input type="hidden" name="role_id" value="{{ $roles->id }}"> <!-- ارسال آیدی نقش -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{__("general.select_permission")}}</label>
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

                    <button type="submit" class="btn btn-success">{{__("general.create_btn")}}</button>
                </form>

            </div>
        </div>
    </div>

@endsection
