@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن دسته انبار')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_warehouse")}}</h5>

                <form id="add_warehouse" action="{{route('warehouses.store')}}" method="POST" class="my-10">
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
                                <label for="address" class="form-label">{{__("general.address")}}</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       id="address"
                                       name="address">
                                @error('address')
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
                                <label for="description" class="form-label">{{__("general.description")}}</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       name="description">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input type="checkbox"
                                       class="form-check-input @error('make_default') is-invalid @enderror"
                                       id="make_default"
                                       name="make_default"
                                       value="1"
                                    {{ old('make_default') ? 'checked' : '' }}>
                                <label class="form-check-label" for="make_default">
                                    {{__("general.set_default_warehouse")}}
                                </label>
                                @error('make_default')
                                <span class="invalid-feedback d-block" role="alert">
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
    {!! JsValidator::formRequest('App\Http\Requests\Warehouse\WarehouseRequest', '#add_warehouse') !!}
@endsection
