@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش کاربر')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_user")}}</h5>

                <form id="edit_user" action="{{route('users.update',$user->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__("general.name")}}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{__("general.email")}}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{__("general.new_password")}}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password">
                        <small class="form-text text-muted">{{__("general.your_new_password")}}
                            کنید.</small>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateUserRequest', '#edit_user') !!}

@endsection
