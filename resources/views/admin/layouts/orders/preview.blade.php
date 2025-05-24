@extends('admin.layouts.project_master_admin')

@section('title', 'پیش‌نمایش سفارش')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">پیش‌نمایش سفارش</h3>

        <div class="card mb-4 p-3">
            <h5>اطلاعات مشتری</h5>
            <p>نام: <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></p>
            <p>آدرس: {{ $customer->country->name ?? '-' }}- {{ $customer->state->name ?? '-' }}- {{ $customer->city->name ?? '-' }}</p>
        </div>

        <div class="card p-3">
            <h5>محصولات انتخاب‌شده</h5>

            <table class="table table-bordered mt-3">
                <thead class="table-light">
                <tr>
                    <th>تصویر</th>
                    <th>نام محصول</th>
                    <th>قیمت واحد</th>
                    <th>تعداد</th>
                    <th>قیمت کل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    @php
                        $quantity = $product_quantities[$product->id];
                        $total = $quantity * $product->price;
                    @endphp
                    <tr>
                        <td style="width: 80px;">
                            <img src="{{ $product->getFirstMediaUrl('product_images') ?: asset('images/no_image.jpg') }}"
                                 alt="Product Image" class="img-fluid rounded" style="height: 60px;">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price) }} دلار</td>
                        <td>{{ $quantity }}</td>
                        <td><strong>{{ number_format($total) }}</strong> دلار</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>جمع کل سفارش:</strong></td>
                    <td><strong class="text-success">{{ number_format($total_price) }} دلار</strong></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            @foreach ($product_quantities as $productId => $quantity)
                <input type="hidden" name="product_quantities[{{ $productId }}]" value="{{ $quantity }}">
            @endforeach

            <button type="submit" class="btn btn-primary">نهایی کردن سفارش</button>
        </form>
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

    <script>
        $(document).ready(function () {
            $('#customer_id').select2({
                placeholder: "یک مشتری را انتخاب کنید",
                allowClear: false,
                width: '100%',
                dropdownParent: $('body')
            });
        });

    </script>

    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerRequest', '#add_order') !!}

@endsection

