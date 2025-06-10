@ -1,103 +0,0 @@
@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش مشخصات ادمین')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_admin")}}</h5>

                <form id="edit_admin" action="{{route('admin.update')}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__("general.name")}}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       name="first_name"
                                       value="{{auth()->guard('admin')->user()->first_name}}"
                                       required>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">{{__("general.last_name")}}</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       name="last_name"
                                       value="{{auth()->guard('admin')->user()->last_name}}"
                                       required>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{__("general.email")}}</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email"
                                       value="{{auth()->guard('admin')->user()->email}}"
                                       required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{__("general.phone")}}</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                       name="phone"
                                       value="{{auth()->guard('admin')->user()->phone}}"
                                       required>
                                @error('phone')
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

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\AdminUpdateRequest', '#edit_admin') !!}

@endsection
