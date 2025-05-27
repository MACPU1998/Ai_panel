@extends('admin.layouts.project_master_admin')

@section('title', 'پیش‌نمایش سفارش')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">پیش‌نمایش سفارش مشتری</h3>

        {{-- اطلاعات مشتری --}}
        <div class="card mb-4 p-3">
            <h5>اطلاعات مشتری</h5>
            <p>نام: <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></p>
            <p>آدرس: {{ $customer->country->name ?? '-' }} - {{ $customer->state->name ?? '-' }} - {{ $customer->city->name ?? '-' }}</p>
        </div>

        {{-- جدول سفارشات مشتری --}}
        <div class="card p-3">
            <h5>تمام سفارشات ثبت‌شده</h5>

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
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalQuantity = 0;
                        $totalAmount = 0;
                    @endphp
                    @foreach($previousOrderItems as $item)
                        @php
                            $totalQuantity += $item->quantity;
                            $totalAmount += $item->price * $item->quantity;
                        @endphp
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td> {{-- نام محصول --}}
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} دلار</td>
                            <td>{{ number_format($item->price * $item->quantity) }} دلار</td> {{-- قیمت کل --}}
                            <td>{{ $item->status ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="text-end"><strong>جمع کل:</strong></td>
                        <td><strong>{{ $totalQuantity }}</strong></td>
                        <td></td>
                        <td><strong class="text-success">{{ number_format($totalAmount) }} دلار</strong></td>
                        <td colspan="2"></td>
                    </tr>
                    </tfoot>
                </table>

            @else
                <div class="alert alert-warning mt-3">
                    هیچ سفارشی برای این مشتری ثبت نشده است.
                </div>
            @endif

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success">{{ __("general.payment") }}</button>
            </div>
        </div>
    </div>
@endsection
