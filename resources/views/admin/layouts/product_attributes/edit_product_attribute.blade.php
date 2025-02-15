@extends('admin.layouts.project-master-admin')

@section('title', 'ویرایش محصول')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_product_attribute")}}</h5>

                <form action="{{route('productAttributes.update',$productAttribute->id)}}" method="POST" class="my-10">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__("general.name")}}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               value="{{ old('name', $productAttribute->name) }}" required>
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
                               value="{{ old('value', $productAttribute->value) }}" required>
                        @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{__("general.status")}} </label>
                        <select name="status" id="status" class="form-control">

                            <option value="1" {{$productAttribute->status == '1' ? 'selected' :''}}>فعال</option>
                            <option value="0" {{$productAttribute->status == '0' ? 'selected' :''}}>غیرفعال</option>

                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">{{__("general.product_id")}}</label>
                        <input type="text" class="form-control @error('product_id') is-invalid @enderror" id="product_id"
                               name="product_id"
                        value="{{ old('product_id', $productAttribute->product_id) }}" required>
                        @error('product_id')
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
