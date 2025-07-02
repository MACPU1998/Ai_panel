@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن کیف پول جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_wallet")}}</h5>

                <form id="add_wallet" action="{{route('wallets.store')}}" method="POST" class="my-10">
                    @csrf

                    <div class="row">

                        <p>nothing</p>


                    </div>

                    <button type="submit" class="btn btn-primary">{{__("general.create_btn")}}</button>
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
            $('#customer').select2({
                placeholder: "یک کاربر را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });
    </script>

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\User\UserRequest', '#add_wallet') !!}

@endsection
