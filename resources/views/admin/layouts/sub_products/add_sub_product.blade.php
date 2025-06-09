@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن زیرمحصول جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_sub_product")}}</h5>

                <form id="add_sub_product" action="{{route('subProducts.store')}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">{{__("general.product")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('product_id') is-invalid @enderror"
                                        id="product_id"
                                        name="product_id"
                                        required>
                                    <option value="">یک محصول را انتخاب کنید</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>

                                    @endforeach
                                </select>
                                @error('product')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="label" class="form-label">{{__("general.label")}}</label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror"
                                       id="label"
                                       name="label">
                                @error('label')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="barcode" class="form-label">{{__("general.barcode")}}</label>
                                <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                       id="barcode"
                                       name="barcode"
                                       required>
                                @error('barcode')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="serial_prefix" class="form-label">{{__("general.serial_prefix")}}</label>
                                <input type="text" class="form-control @error('serial_prefix') is-invalid @enderror"
                                       id="serial_prefix"
                                       name="serial_prefix"
                                       required>
                                @error('serial_prefix')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="serie_year" class="form-label">{{__("general.serie_year")}}</label>
                                <input type="text" class="form-control @error('serie_year') is-invalid @enderror"
                                       id="serie_year"
                                       name="serie_year">
                                @error('serie_year')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="serie_month" class="form-label">{{__("general.serie_month")}}</label>
                                <input type="text" class="form-control @error('serie_month') is-invalid @enderror"
                                       id="serie_month"
                                       name="serie_month">
                                @error('serie_month')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="production_date" class="form-label">{{__("general.production_date")}}</label>
                                <input type="text" class="form-control @error('production_date') is-invalid @enderror"
                                       id="production_date"
                                       name="production_date">
                                @error('production_date')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">{{__("general.expiration_date")}}</label>
                                <input type="text" class="form-control @error('expiration_date') is-invalid @enderror"
                                       id="expiration_date"
                                       name="expiration_date">
                                @error('expiration_date')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="warehouse_id" class="form-label">{{__("general.warehouse")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('warehouse_id') is-invalid @enderror"
                                        id="warehouse_id"
                                        name="warehouse_id"
                                        required>
                                    <option value="">یک انبار را انتخاب کنید</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>

                                    @endforeach
                                </select>
                                @error('warehouse')
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
                                    <option value="0">غیر فعال</option>
                                    <option value="2">مرجوعی</option>
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
            $('#product_id').select2({
                placeholder: "یک محصول را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });

        $(document).ready(function () {
            $('#warehouse_id').select2({
                placeholder: "یک انبار را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });
    </script>

    <script>
        $('#product_id').on('change', function() {
            let productId = $(this).val();

            if (productId) {
                $.get('/admin/sub-products/products/' + productId + '/info', function(product) {
                    $('#serial_prefix').val(product.serial_prefix); // فرض کنیم این فیلد در جدول products هست
                }).fail(function() {
                    alert('محصول پیدا نشد یا خطایی رخ داده است.');
                });
            }
        });

    </script>



    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SubProduct\SubProductRequest', '#add_sub_product') !!}
@endsection

