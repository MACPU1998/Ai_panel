@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن محصول جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_product")}}</h5>

                <form action="{{route('products.store')}}" method="POST" class="my-10" enctype="multipart/form-data">
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
                        <label for="description" class="form-label">{{__("general.description")}}</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                               name="description"
                               >
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{__("general.status")}}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">فعال</option>
                            <option value="1">غیر فعال</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">{{__("general.image")}}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                               name="image"
                               required>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="currency_id" class="form-label">{{__("general.currency_id")}}</label>
                        <input type="text" class="form-control @error('currency_id') is-invalid @enderror" id="currency_id"
                               name="currency_id"
                               required>
                        @error('currency_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">{{__("general.price")}}</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                               name="price"
                               required>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="final_price" class="form-label">{{__("general.final_price")}}</label>
                        <input type="text" class="form-control @error('final_price') is-invalid @enderror" id="final_price"
                               name="final_price"
                               >
                        @error('final_price')
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
