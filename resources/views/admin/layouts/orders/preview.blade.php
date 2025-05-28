@extends('admin.layouts.project_master_admin')

@section('title', 'پیش‌نمایش سفارش')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">پیش‌نمایش سفارش مشتری</h3>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            {{-- اطلاعات مشتری --}}
            <div class="card mb-4 p-3">
                <h5>اطلاعات مشتری</h5>
                <p>نام: <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></p>
                <p>آدرس: {{ $customer->country->name ?? '-' }} - {{ $customer->state->name ?? '-' }} - {{ $customer->city->name ?? '-' }}</p>
                <p>هزینه ارسال: <strong>{{ number_format($shippingCost) }} تومان</strong></p>
            </div>

            {{-- لیست سفارشات --}}
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
                                <td>{{ number_format($item->price) }} تومان</td>
                                <td>{{ number_format($item->price * $item->quantity) }} تومان</td>
                                <td>{{ $item->status_label  ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i') }}</td>
                                <td>{{ number_format($shippingCost) }} تومان</td>
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
                                    {{ number_format($totalAmount) }} تومان
                                </strong>
                            </td>
                            <td colspan="2"></td>
                            <td>
                                <div id="shippingCostText" class="text-secondary small">
                                    هزینه ارسال: {{ number_format($shippingCost) }} تومان
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>جمع نهایی (با هزینه ارسال):</strong></td>
                            <td colspan="4">
                                <strong class="text-primary">
                                    {{ number_format($totalAmount + $shippingCost) }} تومان
                                </strong>
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


                    @if($subProducts->count())
                        <div class="card mt-4 p-3">
                            <h5>زیرمحصولات سفارش</h5>
                            <table class="table table-bordered mt-2">
                                <thead class="table-light">
                                <tr>
                                    <th>بارکد</th>
                                    <th>نام زیرمحصول</th>
                                    <th>لیبل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subProducts as $sub)
                                    <tr>
                                        <td>{{ $sub->barcode ?? '-' }}</td>
                                        <td>{{ $sub->subProduct->product->name ?? '-' }}</td>
                                        <td>{{ $sub->subProduct->label  ?? '-' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                        @if($latestOrder)
                            @if($latestOrder->status == 1)
                                {{-- پرداخت --}}
                                <form method="POST" action="{{ route('orders.store') }}">
                                    @csrf
                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                    <button type="submit" class="btn btn-success">{{ __("general.payment") }}</button>
                                </form>

                            @elseif($latestOrder->status == 2)
                                {{-- تایید ادمین --}}
                                <form method="POST" style="display:inline;" onsubmit="return confirm('تایید ادمین انجام شود؟')">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $latestOrder->id }}">
                                    <button type="submit" formaction="{{ url('/admin/orders/confirm-local') }}" class="btn btn-warning">
                                        تایید ادمین
                                    </button>
                                </form>


                            @elseif($latestOrder->status == 3)
                                {{-- چاپ فاکتور --}}
                                <a href="{{ route('orders.invoice', $latestOrder->id) }}" class="btn btn-info" target="_blank">چاپ فاکتور</a>
                            @endif
                        @endif
            </div>


        </form>
    </div>
@endsection
