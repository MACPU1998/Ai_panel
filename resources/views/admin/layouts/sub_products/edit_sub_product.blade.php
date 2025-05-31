@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش زیرمحصول')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_sub_product")}}</h5>

                <form id="edit_sub_product" action="{{route('subProducts.update',$subProduct->id)}}" method="POST"
                      class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                        <option
                                            value="{{ $product->id }}" {{ $subProduct->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
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
                                       value="{{ old('barcode', $subProduct->barcode) }}"
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
                                <label for="serie_year" class="form-label">{{__("general.serie_year")}}</label>
                                <input type="text" class="form-control @error('serie_year') is-invalid @enderror"
                                       id="serie_year"
                                       name="serie_year"
                                       value="{{ old('serie_year', $subProduct->serie_year) }}">
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
                                       value="{{ old('serie_month', $subProduct->serie_month) }}"
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
                                <label for="label" class="form-label">{{__("general.label")}}</label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror"
                                       id="label"
                                       value="{{ old('label', $subProduct->label) }}"
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
                                <label for="production_date" class="form-label">{{__("general.production_date")}}</label>
                                <input type="text" class="form-control @error('production_date') is-invalid @enderror"
                                       id="production_date"
                                       value="{{ old('production_date', $subProduct->production_date) }}"
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
                                       value="{{ old('expiration_date', $subProduct->expiration_date) }}"
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
                                        <option
                                            value="{{ $warehouse->id }}" {{ $subProduct->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
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
                                    <option value="1" {{$subProduct->status == '1' ? 'selected' :''}}>فعال</option>
                                    <option value="0" {{$subProduct->status == '0' ? 'selected' :''}}>غیرفعال</option>
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

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SubProduct\SubProductRequest', '#edit_sub_product') !!}

@endsection
