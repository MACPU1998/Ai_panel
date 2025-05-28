@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن تنظیمات')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_setting")}}</h5>

                <form id="add_setting" action="{{route('settings.store')}}" method="POST" class="my-10">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="key" class="form-label">{{__("general.name")}}</label>
                                <input type="text" class="form-control @error('key') is-invalid @enderror" id="key"
                                       name="key"
                                       required>
                                @error('key')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="value" class="form-label">{{__("general.value")}}</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                                       name="value"
                                       >
                                @error('value')
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
    {!! JsValidator::formRequest('App\Http\Requests\Setting\SettingRequest', '#add_setting') !!}
@endsection
