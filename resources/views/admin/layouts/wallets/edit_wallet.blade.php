@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش کیف پول')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_wallet")}}</h5>

                <form id="edit_wallet" action="{{route('wallets.update',$wallet->id,$customer->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="balance" class="form-label">{{__("general.balance")}}</label>
                                <input type="number" class="form-control @error('balance') is-invalid @enderror"
                                       id="balance"
                                       name="balance" autocomplete="off"
                                       required>
                                @error('balance')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="description" class="form-label">{{__("general.description")}}</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       name="description" autocomplete="off"
                                       >
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{__("general.edit_btn")}}</button>
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
        const balanceInput = document.getElementById('balance');

        balanceInput.addEventListener('input', function () {
            let raw = this.value.replace(/[^0-9]/g, '');
            this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });

        document.getElementById('walletForm').addEventListener('submit', function () {
            balanceInput.value = balanceInput.value.replace(/,/g, '');
        });
    </script>

{{--    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>--}}
{{--    {!! JsValidator::formRequest('App\Http\Requests\User\UserUpdateRequest', '#edit_user') !!}--}}

@endsection
