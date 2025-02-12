@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن ارز جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_product_currency")}}</h5>

                <form action="{{route('productCurrencies.store')}}" method="POST" class="my-10">
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
                        <label for="name" class="form-label">{{__("general.slug")}}</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                               name="slug"
                               required>
                        @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{__("general.status")}}</label>
                        <select name="status" id="status" class="form-control">
                            <option>0</option>
                            <option>1</option>
                        </select>
                        @error('status')
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
