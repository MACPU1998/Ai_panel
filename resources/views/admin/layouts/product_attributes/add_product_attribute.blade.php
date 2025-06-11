@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن ویژگی جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_product_attribute")}}</h5>

                <form id="add_product_attribute" action="{{route('productAttributes.store')}}" method="POST"
                      class="my-10">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{__("general.name")}}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       name="name"
                                       required>
                                @error('name')
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
                                       required>
                                @error('value')
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

                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">{{__("general.product")}}</label>
                                <select type="text" class="form-control @error('product_id') is-invalid @enderror"
                                        id="product_id"
                                        name="product_id"
                                        required>
                                    <option value="">یک محصول را انتخاب کنید</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
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
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ProductAttribute\ProductAttributeRequest', '#add_product_attribute') !!}
@endsection
