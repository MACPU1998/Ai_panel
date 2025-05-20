@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن سفارش جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_customer")}}</h5>

                <form id="add_order" action="{{route('orders.store')}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">{{__("general.customer")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('customer_id') is-invalid @enderror"
                                        id="customer_id"
                                        name="customer_id"
                                        required>
                                    <option value="">یک مشتری را انتخاب کنید</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>

                                    @endforeach
                                </select>
                                @error('customer_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shipping_price" class="form-label">{{__("general.shipping_price")}}</label>
                                <input type="number" class="form-control @error('shipping_price') is-invalid @enderror"
                                       id="shipping_price"
                                       name="shipping_price">
                                @error('shipping_price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tax_price" class="form-label">{{__("general.tax_price")}}</label>
                                <input type="number" class="form-control @error('tax_price') is-invalid @enderror"
                                       id="tax_price"
                                       name="tax_price">
                                @error('tax_price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">{{__("general.quantity")}}</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity"
                                       name="quantity">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_price" class="form-label">{{__("general.total_price")}}</label>
                                <input type="number" class="form-control @error('total_price') is-invalid @enderror"
                                       id="total_price"
                                       name="total_price"
                                       required>
                                @error('total_price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="final_price" class="form-label">{{__("general.final_price")}}</label>
                                <input type="number" class="form-control @error('final_price') is-invalid @enderror"
                                       id="final_price"
                                       name="final_price"
                                       required>
                                @error('final_price')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">{{__("general.status")}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">فعال</option>
                                </select>
                                @error('status')
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
            $('#customer_id').select2({
                placeholder: "یک مشتری را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });

    </script>

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerRequest', '#add_order') !!}

@endsection

