@extends('admin.layouts.project_master_admin')
@section('title', 'ویرایش سفارش')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.edit_order")}}</h5>

                <form id="edit_order" action="{{ route('orders.index') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">مشتری</label>
                            <input type="text" class="form-control" value="{{ $order->customer->first_name }} {{ $order->customer->last_name }}" disabled>
                            <input type="hidden" name="customer_id" value="{{ $order->customer->id }}">
                        </div>


                    <hr class="my-4">

                    <div class="col-md-12">
                        <label class="form-label d-block">محصولات</label>
                        <div class="row" id="product-list">
                            @forelse($products as $product)
                                @php
                                    $quantityInOrder = $subProductQuantities[$product->id] ?? '';
                                    $available = $product->activeSubProducts()->count();
                                @endphp
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ $product->getFirstMediaUrl('product_images') ?: asset('images/no_image.jpg') }}"
                                             class="card-img-top product-image" alt="Product Image">

                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div>
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <p class="card-text">قیمت: {{ number_format($product->price) }} تومان</p>
                                                <p class="card-text">موجودی: {{ $available }}</p>
                                            </div>

                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <input type="number"
                                                       class="form-control form-control-sm quantity-input"
                                                       name="product_quantities[{{ $product->id }}]"
                                                       id="quantity_{{ $product->id }}"
                                                       min="1"
                                                       max="{{ $available }}"
                                                       value="{{ $quantityInOrder }}"
                                                       placeholder="تعداد"
                                                       style="width: 70px;">

                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success add-to-cart"
                                                        data-product-id="{{ $product->id }}">
                                                    افزودن
                                                </button>
                                            </div>

                                            <div id="status_{{ $product->id }}" class="text-success mt-1 small d-none">
                                                به‌روزرسانی شد ✔️
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>هیچ محصول فعالی با موجودی یافت نشد.</p>
                            @endforelse
                        </div>
                    </div>

                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success">ذخیره تغییرات و برگشت به صفحه</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const customerId = "{{ $order->customer_id }}";

            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.dataset.productId;
                    const quantityInput = document.getElementById('quantity_' + productId);
                    const quantity = parseInt(quantityInput?.value);

                    if (!quantityInput || isNaN(quantity) || quantity < 1) {
                        alert('تعداد باید حداقل 1 باشد.');
                        return;
                    }

                    fetch('/admin/orders/add-to-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            customer_id: customerId,
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const status = document.getElementById('status_' + productId);
                                status.classList.remove('d-none');
                                status.textContent = 'به‌روزرسانی شد ✔️';
                            } else {
                                alert(data.message || 'خطا در بروزرسانی سفارش.');
                            }
                        })
                        .catch(() => alert('مشکلی پیش آمده.'));
                });
            });
        });
    </script>
@endsection
