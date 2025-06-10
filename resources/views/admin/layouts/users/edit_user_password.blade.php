@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش رمز ادمین')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_admin_password")}}</h5>

                <form id="edit_user_password" action="{{route('users.update.password',$admin->id)}}" method="POST"
                      class="my-10">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{__("general.current_password")}}</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">{{__("general.new_password")}}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password_confirmation"
                                   class="form-label">{{__("general.confirm_new_password")}}</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" required>
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

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\User\UserUpdateRequest', '#edit_user_password') !!}

@endsection
