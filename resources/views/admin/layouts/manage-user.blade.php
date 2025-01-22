<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کاربران</title>

    <!-- لینک به استایل های Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- لینک به استایل های DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>

<div class="container mt-8">
    <h1 class="mb-4">مدیریت کاربران</h1>
    <a href="#" class="btn btn-success mb-3">اضافه کردن کاربر جدید</a>
    {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
</div>

<!-- جاوا اسکریپت های مورد نیاز Bootstrap و DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '', // تغییر نام روت به userDataTable
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'created_at' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

</body>
</html>
