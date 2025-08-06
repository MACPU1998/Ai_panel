<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'vazir', sans-serif;
            direction: rtl;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
    </style>
    <title>دانلود PDF</title>
</head>
<body>

<h2>زیرمحصول‌های انبار {{ $warehouse->name }}</h2>

<table>
    <thead>
    <tr>
        <th>شناسه</th>
        <th>نام محصول</th>
        <th>برچسب</th>
        <th>بارکد</th>
        <th>وضعیت</th>
        <th>تاریخ تولید</th>
        <th>تاریخ انقضا</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subProducts as $subProduct)
        <tr>
            <td>{{ $subProduct->id }}</td>
            <td>{{ $subProduct->product->name ?? '---' }}</td>
            <td>{{ $subProduct->label }}</td>
            <td>{{ $subProduct->barcode }}</td>
            <td>{{ $subProduct->status_label }}</td>
            <td>{{ $subProduct->production_date }}</td>
            <td>{{ $subProduct->expiration_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
