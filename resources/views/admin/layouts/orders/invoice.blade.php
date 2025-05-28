<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>فاکتور سفارش</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; direction: rtl; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>فاکتور سفارش</h2>

<p><strong>نام مشتری:</strong> {{ $customer->first_name }} {{ $customer->last_name }}</p>
<p><strong>شماره سفارش:</strong> {{ $order->id }}</p>
<p><strong>تاریخ سفارش:</strong> {{ \Morilog\Jalali\Jalalian::fromCarbon($order->created_at)->format('Y/m/d H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>نام محصول</th>
        <th>تعداد</th>
        <th>قیمت واحد</th>
        <th>قیمت کل</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderItems as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price) }} تومان</td>
            <td>{{ number_format($item->price * $item->quantity) }} تومان</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p style="text-align: left; margin-top: 30px;">
    <strong>جمع کل سفارش:</strong> {{ number_format($order->total_price) }} تومان <br>
    <strong>هزینه ارسال:</strong> {{ number_format($order->shipping_price) }} تومان <br>
    <strong>مبلغ نهایی:</strong> {{ number_format($order->final_price) }} تومان
</p>

</body>
</html>
