@extends('admin.layouts.project-master-admin')

@section('title', 'اضافه کردن محصول جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_product")}}</h5>

                <form action="{{route('products.store')}}" method="POST" class="my-10" enctype="multipart/form-data">
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
                                <label for="description" class="form-label">{{__("general.description")}}</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       name="description">
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency_id" class="form-label">{{__("general.currency_id")}}</label>
                                <input type="text" class="form-control @error('currency_id') is-invalid @enderror"
                                       id="currency_id"
                                       name="currency_id"
                                       required>
                                @error('currency_id')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">

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
                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="final_price" class="form-label">{{__("general.final_price")}}</label>
                                <input type="text" class="form-control @error('final_price') is-invalid @enderror"
                                       id="final_price"
                                       name="final_price">
                                @error('final_price')
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
                                <label for="image" class="form-label">{{__("general.image")}}</label>
                                <input type="file" class="form-control dropify @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       @if(isset($product) && $product->image)
                                           data-default-file="{{ asset('storage/'.$product->image) }}"
                                       @endif
                                       required>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                   </span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div id="attr-action" class="col-md-5">

                        <div class="card card-inverse card-success text-white bg-success">
                            <div class="card-header">مشخصات</div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <small><span
                                            class="text-white">میتوانید برای محصول ویژگی تعریف کنید</span></small>
                                </div>
                                <br>
                                <input type="text" id="map_data" value="51" name="id" hidden="">
                                <input type="text" id="attributes" name="attributes" hidden="">
                                <a id="attr-add" style="float:right;margin-left: 5px;" class="btn btn-warning">تایید</a>
                                <input id="attr-name" class="form-control"
                                       style="float:right;width:120px;margin-left: 5px;" placeholder="نام مشخصه">
                                <input id="attr-value" class="form-control"
                                       style="float:right;width:120px;margin-left: 5px;" placeholder="مقدار">
                                <div id="list-attrs" class="form-group">
                                    <ul>


                                    </ul>
                                </div>
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

                // فعال‌سازی Dropify
                $('.dropify').dropify({
                    messages: {
                        'default': 'یک فایل را اینجا بکشید و رها کنید یا کلیک کنید',
                        'replace': 'برای جایگزینی، فایل جدید را بکشید و رها کنید یا کلیک کنید',
                        'remove': 'حذف',
                        'error': 'متاسفانه مشکلی پیش آمد'
                    }
                });

                var attrs = [];
                // افزودن ویژگی جدید
                $("#attr-action #attr-add").on("click", function () {
                    attrs.push({
                        name: $("#attr-action #attr-name").val(),
                        value: $("#attr-action #attr-value").val()
                    });
                    $("#attr-action #attributes").val(JSON.stringify(attrs)); // ارسال به صورت رشته JSON

                    console.log(JSON.stringify(attrs)); // بررسی داده‌ها در کنسول
                    generateList(attrs);
                    return false;
                });

                // حذف ویژگی
                $("#attr-action #list-attrs ul").on("click", "#remove", function () {
                    var i = $($(this).parent()).index();
                    delete attrs[i];
                    $(this).parent().remove();
                    attrs = attrs.filter(isNotNull); // حذف مقادیر null
                    $("#attr-action input#attributes").val(JSON.stringify(attrs)); // به‌روزرسانی فیلد hidden
                    console.log(JSON.stringify(attrs)); // بررسی داده‌ها در کنسول
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

        function GetDynamicTextBox(value) {
            return '<div class="d-flex gap-3 mb-3">' +
                '<input name="attributes[][name]" type="text" class="form-control" value="' + value + '" />' +
                '<input name="attributes[][value]" type="text" class="form-control" />' +
                '</div>';
        }

    </script>

@endsection

