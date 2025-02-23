@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن کالای جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_goods")}}</h5>

                <form action="{{route('goods.store')}}" method="POST" class="my-10" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">{{__("general.product_id")}}</label>
                                <select type="text" class="form-control @error('product_id') is-invalid @enderror"
                                        id="product_id"
                                        name="product_id"
                                        required>
                                    <option value="">یک محصول را انتخاب کنید</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="barcode" class="form-label">{{__("general.barcode")}}</label>
                                <input type="number" class="form-control @error('barcode') is-invalid @enderror"
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
                                <label for="serial_date" class="form-label">{{__("general.serial_date")}}</label>
                                <input type="text" class="form-control @error('serial_date') is-invalid @enderror"
                                       id="serial_date"
                                       name="serial_date">
                                @error('serial_date')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="version" class="form-label">{{__("general.version")}}</label>
                                <input type="text" class="form-control @error('version') is-invalid @enderror"
                                       id="version"
                                       name="version">
                                @error('version')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">{{__("general.status")}}</label>
                                <select name="status" id="status" class="form-control" required>
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

                    </div>

                    <button type="submit" class="btn btn-success">{{__("general.create_btn")}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
