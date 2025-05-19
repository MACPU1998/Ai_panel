@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش مشتری')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_customer")}}</h5>

                <form id="edit_customer" action="{{route('customers.update',$customer->id)}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__("general.first_name")}}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                       name="first_name"
                                       value="{{ old('first_name', $customer->first_name) }}"
                                       required>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">{{__("general.last_name")}}</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                       name="last_name"
                                       value="{{ old('last_name', $customer->last_name) }}"
                                       required>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{__("general.phone")}}</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                       name="phone"
                                       value="{{ old('phone', $customer->phone) }}"
                                       required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="national_id" class="form-label">{{__("general.national_id")}}</label>
                                <input type="number" class="form-control @error('national_id') is-invalid @enderror" id="national_id"
                                       name="national_id"
                                       value="{{ old('national_id', $customer->national_id) }}">
                                @error('national_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">{{__("general.birth_date")}}</label>
                                <input type="text" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                       name="birth_date"
                                       value="{{ old('birth_date', $customer->birth_date) }}">
                                @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="country_id" class="form-label">{{__("general.country")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('country_id') is-invalid @enderror"
                                        id="country_id"
                                        name="country_id">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $customer->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
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
                                <label for="image" class="form-label">{{ __("general.image") }}</label>
                                <input type="file" class="form-control dropify @error('image') is-invalid @enderror"
                                       id="image" name="image"
                                       data-default-file="{{ $customer->getFirstMediaUrl('customer_images') ?? '' }}">
                                @error('image')
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
        $(function () {

            $(document).ready(function () {

                $('.dropify').dropify({
                    messages: {
                        'default': 'یک فایل را اینجا بکشید و رها کنید یا کلیک کنید',
                        'replace': 'برای جایگزینی، فایل جدید را بکشید و رها کنید یا کلیک کنید',
                        'remove': 'حذف',
                        'error': 'متاسفانه مشکلی پیش آمد'
                    }
                });

            });

        });


    </script>

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
            $('#country_id').select2({
                placeholder: "کشور خود را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#state_id').select2({
                placeholder: "استان خود را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#city_id').select2({
                placeholder: "شهر خود را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });
    </script>

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerRequest', '#edit_customer') !!}

@endsection
