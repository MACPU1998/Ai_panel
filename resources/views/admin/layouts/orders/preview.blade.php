@extends('admin.layouts.project_master_admin')

@section('title', 'پیش‌نمایش سفارش')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">پیش‌نمایش سفارش مشتری</h3>

            <form method="POST" action="{{ route('orders.store') }}">

            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">


            <div class="card mb-4 p-3">
                <h5>اطلاعات مشتری</h5>
                <p>نام: <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></p>
                <p>آدرس: {{ $customer->country->name ?? '-' }} - {{ $customer->state->name ?? '-' }} - {{ $customer->city->name ?? '-' }}</p>

                <h5>روش ارسال</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shipping_method_radio" id="freeShipping" value="0" checked>
                    <label class="form-check-label" for="freeShipping">
                        ارسال رایگان
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shipping_method_radio" id="paidShipping" value="50000">
                    <label class="form-check-label" for="paidShipping">
                        ارسال با پست (۵۰,۰۰۰ تومان)
                    </label>
                </div>

                <input type="hidden" name="shipping_method" id="shippingMethodInput" value="0">
            </div>

            <div class="card p-3">
                <h5>سفارشات ثبت ‌شده</h5>

                @php
                    $totalQuantity = 0;
                    $totalAmount = 0;
                @endphp

                @if($previousOrderItems->count())
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                        <tr>
                            <th>نام محصول</th>
                            <th>تعداد</th>
                            <th>قیمت واحد</th>
                            <th>قیمت کل</th>
                            <th>وضعیت</th>
                            <th>تاریخ سفارش</th>
                            <th>هزینه پست</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($previousOrderItems as $item)
                            @php
                                $totalQuantity += $item->quantity;
                                $totalAmount += $item->price * $item->quantity;
                            @endphp
                            <tr>
                                <td>{{ $item->product_name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price) }} دلار</td>
                                <td>{{ number_format($item->price * $item->quantity) }} دلار</td>
                                <td>{{ $item->status ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i') }}</td>
                                <td>-</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-end"><strong>جمع کل:</strong></td>
                            <td><strong>{{ $totalQuantity }}</strong></td>
                            <td></td>
                            <td>
                                <strong class="text-success" id="totalAmount">
                                    {{ number_format($totalAmount) }} دلار
                                </strong>
                            </td>
                            <td colspan="2"></td>
                            <td>
                                <div id="shippingCostText" class="text-secondary small">هزینه ارسال: ۰ تومان</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="alert alert-warning mt-3">
                        هیچ سفارشی برای این مشتری ثبت نشده است.
                    </div>
                @endif
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">{{ __("general.payment") }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shippingRadios = document.querySelectorAll('input[name="shipping_method_radio"]');
            const totalAmountElement = document.getElementById('totalAmount');
            const shippingCostText = document.getElementById('shippingCostText');
            const shippingMethodInput = document.getElementById('shippingMethodInput');

            let baseTotal = {{ $totalAmount ?? 0 }};

            function updateShipping() {
                const selected = document.querySelector('input[name="shipping_method_radio"]:checked');
                const shippingCost = parseInt(selected.value);
                const newTotal = baseTotal + shippingCost;

                totalAmountElement.textContent = new Intl.NumberFormat().format(newTotal) + ' دلار';
                shippingCostText.textContent = 'هزینه ارسال: ' + new Intl.NumberFormat().format(shippingCost) + ' تومان';
                shippingMethodInput.value = shippingCost;
            }

            shippingRadios.forEach(radio => {
                radio.addEventListener('change', updateShipping);
            });

            // اجرای اولیه برای مقدار پیش‌فرض
            updateShipping();
        });
    </script>
@endpush
