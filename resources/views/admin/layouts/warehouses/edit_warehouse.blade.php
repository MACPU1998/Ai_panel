@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش انبار')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_warehouse")}}</h5>

                <form id="edit_warehouse" action="{{route('warehouses.update',$warehouse->id)}}" method="POST"
                      class="my-10">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{__("general.name")}}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       name="name"
                                       value="{{ old('name', $warehouse->name) }}" required>
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
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                       name="address"
                                       value="{{ old('address', $warehouse->address) }}" >
                                @error('slug')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">{{__("general.status")}} </label>
                                <select name="status" id="status" class="form-control">

                                    <option value="1" {{$warehouse->status == '1' ? 'selected' :''}}>فعال</option>
                                    <option value="0" {{$warehouse->status == '0' ? 'selected' :''}}>غیرفعال</option>


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
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                                       name="description"
                                       value="{{ old('description', $warehouse->description) }}" >
                                @error('slug')
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

                    <button type="submit" class="btn btn-primary">{{__("general.edit_btn")}}</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\Warehouse\UpdateWarehouseRequest', '#edit_warehouse') !!}
@endsection
