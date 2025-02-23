@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش محصول')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_goods")}}</h5>

                <form action="{{route('goods.update',$goods->id)}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                        <option
                                            value="{{$product->id}}" {{$goods->product_id==$product->id?'selected':''}}>{{$product->name}}</option>

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
                                       value="{{ old('barcode', $goods->barcode) }}"
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
                                       name="serial_date"
                                       value="{{ old('serial_date', $goods->serial_date) }}">
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
                                       value="{{ old('version', $goods->version) }}"
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
                                    <option value="1" {{$goods->status == '1' ? 'selected' :''}}>فعال</option>
                                    <option value="0" {{$goods->status == '0' ? 'selected' :''}}>غیرفعال</option>
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
