@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش ادمین')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_admin")}}</h5>

                <form id="edit_user" action="{{route('users.update',$admin->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__("general.name")}}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       name="first_name"
                                       value="{{ old('first_name', $admin->first_name) }}" required>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">{{__("general.last_name")}}</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       name="last_name"
                                       value="{{ old('last_name', $admin->last_name) }}" required>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{__("general.email")}}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email"
                                       value="{{ old('email', $admin->email) }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{__("general.phone")}}</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $admin->phone) }}" required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="role" class="form-label">{{__("general.role")}}</label>
                                <select type="text" class="form-control select2 @error('role') is-invalid @enderror"
                                        id="role"
                                        name="role"
                                        required>
                                    <option value="">یک نقش را انتخاب کنید</option>
                                    @foreach($roles as $role)
                                        <option
                                            value="{{ $role->name }}" {{ isset($admin) && $admin->roles->pluck('name')->first() == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success">{{__("general.edit_btn")}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("form").addEventListener("keypress", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#role').select2({
                placeholder: "یک نقش را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });
    </script>

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\User\UserUpdateRequest', '#edit_user') !!}

@endsection
