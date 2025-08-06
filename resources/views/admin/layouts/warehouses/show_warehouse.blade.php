@extends('admin.layouts.project_master_admin')

@section('title', 'ویرایش انبار')

@section('content')

    <h5>زیرمحصول‌های انبار: {{ $warehouse->name }}</h5>

    <form id="transfer-form" method="POST" action="{{ route('warehouses.transferSubProducts') }}">
        @csrf
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th><input type="checkbox" id="check-all" /></th>
                <th>شناسه</th>
                <th>نام</th>
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
                    <td><input type="checkbox" name="sub_product_ids[]" value="{{ $subProduct->id }}"></td>
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

        <button type="button" class="btn btn-primary" id="open-transfer-modal">انتقال</button>

        <div class="d-flex justify-content-center mt-3">
            {{ $subProducts->links() }}
        </div>
        <!-- Modal -->
        <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">انتقال زیرمحصولات</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">انتخاب انبار مقصد:</label>
                            <select name="warehouse_id" class="form-select" required>
                                @foreach(\App\Models\Warehouse::where('id', '!=', $warehouse->id)->get() as $otherWarehouse)
                                    <option value="{{ $otherWarehouse->id }}">{{ $otherWarehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تأیید انتقال</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">لغو</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('open-transfer-modal').addEventListener('click', function () {
                if (document.querySelectorAll('input[name="sub_product_ids[]"]:checked').length === 0) {
                    alert('لطفاً حداقل یک زیرمحصول را انتخاب کنید.');
                    return;
                }
                new bootstrap.Modal(document.getElementById('transferModal')).show();
            });

            document.getElementById('check-all').addEventListener('change', function () {
                document.querySelectorAll('input[name="sub_product_ids[]"]').forEach(function (checkbox) {
                    checkbox.checked = event.target.checked;
                });
            });
        });
    </script>


@endsection
