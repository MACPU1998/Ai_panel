@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن مشتری جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_customer")}}</h5>

                <form id="add_customer" action="{{route('customers.store')}}" method="POST" class="my-10"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">{{__("general.first_name")}}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       name="first_name"
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
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       name="last_name"
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
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
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
                                <input type="number" class="form-control @error('national_id') is-invalid @enderror"
                                       id="national_id"
                                       name="national_id">
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
                                <input type="text" class="form-control @error('birth_date') is-invalid @enderror"
                                       id="birth_date"
                                       name="birth_date">
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
                                    <option value="">کشور خود را انتخاب</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="state_id" class="form-label">{{__("general.state")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('state_id') is-invalid @enderror"
                                        id="state_id"
                                        name="state_id">
                                    <option value="">استان خود را انتخاب کنید</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city_id" class="form-label">{{__("general.city")}}</label>
                                <select type="text"
                                        class="form-control select2 @error('city_id') is-invalid @enderror"
                                        id="city_id"
                                        name="city_id">
                                    <option value="">شهر خود را انتخاب کنید</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">{{__("general.image")}}</label>
                                <input type="file" class="form-control dropify @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image">
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

                var attrs = [];
                $("#attr-action #attr-add").on("click", function () {
                    attrs.push({
                        name: $("#attr-action #attr-name").val(),
                        value: $("#attr-action #attr-value").val()
                    });
                    $("#attr-action #attributes").val(JSON.stringify(attrs));

                    console.log(JSON.stringify(attrs));
                    generateList(attrs);
                    return false;
                });

                $("#attr-action #list-attrs ul").on("click", "#remove", function () {
                    var i = $($(this).parent()).index();
                    delete attrs[i];
                    $(this).parent().remove();
                    attrs = attrs.filter(isNotNull);
                    $("#attr-action input#attributes").val(JSON.stringify(attrs));
                    console.log(JSON.stringify(attrs));
                    return false;
                });

                function generateList(data) {
                    $("#attr-action #list-attrs ul").empty();
                    if (data != null) {
                        $.each(data, function (i, v) {
                            var code = "<li><div><label class='attr-name'>" + v.name + "</label></div><div>";
                            code += "<label> : " + v.value + "</label></div><a href='#' id='remove'>X</button></a></li>";

                            $("#attr-action #list-attrs ul").append(code);
                        });
                    } else {
                        attrs = [];
                    }
                }

                function isNotNull(value) {
                    return value != null;
                }
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
    {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerRequest', '#add_customer') !!}

@endsection

