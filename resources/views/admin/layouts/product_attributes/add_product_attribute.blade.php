@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن ویژگی جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_product_attribute")}}</h5>

                <form action="{{route('productAttributes.store')}}" method="POST" class="my-10">
                    @csrf

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

                    <div class="mb-3">
                        <label for="product_id" class="form-label">{{__("general.product_id")}}</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="product_id"
                               name="product_id"
                               required>
                        @error('product_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">{{__("general.create_btn")}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
