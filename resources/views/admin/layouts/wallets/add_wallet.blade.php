@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن ادمین جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_admin")}}</h5>

                <form id="add_user" action="{{route('users.store')}}" method="POST" class="my-10">
                    @csrf

                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__("general.first_name")}}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       name="first_name" autocomplete="off"
                                       required>
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
                                       name="last_name" autocomplete="off"
                                       required>
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email" autocomplete="off"
                                       required>
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
                                       name="phone" autocomplete="off"
                                       required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{__("general.password")}}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" autocomplete="new-password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{__("general.confirm_password")}}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password_confirmation" name="password_confirmation"
                                       autocomplete="new-password" required>
                                @error('confirm_password')
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
                                        <option value="{{$role->name}}">{{$role->name}}</option>

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

                    <button type="submit" class="btn btn-success">{{__("general.create_btn")}}</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\User\UserRequest', '#add_user') !!}

@endsection
