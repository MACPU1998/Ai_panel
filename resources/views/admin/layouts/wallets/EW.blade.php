@extends('admin.layouts.project_master_admin')

@section('title', 'مدیریت کیف پول مشتری')

@section('content')
    <div class="container mt-5">
        <h4>مدیریت کیف پول مشتری: {{ $customer->first_name . ' ' . $customer->last_name }}</h4>

        <div class="card mt-4">
            <div class="card-body">
                <p><strong>مقدار فعلی کیف پول:</strong> {{ number_format($customer->wallet->balance ?? 0) }} تومان</p>


                <form action="{{ route('wallets.update', $customer->id,$wallet->id) }}" method="POST" id="walletForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="balance" class="form-label">ویرایش کیف پول</label>
                        <input type="text" class="form-control" name="balance" id="balance" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">توضیحات (اختیاری)</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>

                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">بازگشت</a>
                </form>

            </div>
        </div>
    </div>
    {{-- 🔻 اسکریپت مستقیم داخل صفحه --}}
    <script>
        const balanceInput = document.getElementById('balance');

        balanceInput.addEventListener('input', function () {
            let raw = this.value.replace(/[^0-9]/g, '');
            this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });

        document.getElementById('walletForm').addEventListener('submit', function () {
            balanceInput.value = balanceInput.value.replace(/,/g, '');
        });
    </script>
@endsection
