@extends('admin.layouts.project_master_admin')

@section('title', 'اضافه کردن سفارش جدید')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="container mt-8">
                <h5 class="mb-4">{{__("general.add_order")}}</h5>

                <form id="add_order" action="" method="GET" class="my-10" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">{{ __("general.customer") }}</label>
                                    <select type="text"
                                            class="form-control select2 @error('customer_id') is-invalid @enderror"
                                            id="customer_id"
                                            name="customer_id"
                                            required>
                                        <option value="">یک مشتری را انتخاب کنید</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">{{ __("general.add_customer") }}</a>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label d-block">محصولات</label>
                            <div class="row" id="product-list">
                                @forelse($products as $product)
                                    <div class="col-md-3">
                                        <div class="card h-100 shadow-sm">
                                            <img src="{{ $product->getFirstMediaUrl('product_images') ?: asset('images/no_image.jpg') }}"
                                                 class="card-img-top product-image" alt="Product Image">

                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div>
                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                    <p class="card-text">قیمت: {{ number_format($product->price) }} دلار</p>
                                                    <p class="card-text">موجودی: {{ $product->active_sub_product_count }}</p>
                                                </div>

                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <input type="number"
                                                           class="form-control form-control-sm quantity-input"
                                                           name="product_quantities[{{ $product->id }}]"
                                                           id="quantity_{{ $product->id }}"
                                                           min="1"
                                                           max="{{ $product->active_sub_product_count }}"
                                                           value=""
                                                           placeholder="تعداد"
                                                           style="width: 70px;">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-success add-to-cart"
                                                            data-sub-product-id="{{ $product->activeSubProducts->first()->id }}"
                                                            data-product-id="{{ $product->id }}">
                                                        افزودن
                                                    </button>


                                                </div>

                                                <div id="status_{{ $product->id }}" class="text-success mt-1 small d-none">
                                                    به سبد اضافه شد ✔️
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
                        <button type="submit" class="btn btn-success">{{ __("general.next") }}</button>
                    </div>
                </form>


            </div>
    </div>
@endsection
@section('customjs')

            <script>
                document.addEventListener('DOMContentLoaded', function () {



                    const addedProducts = new Set();

                    document.querySelectorAll('.add-to-cart').forEach(button => {
                        button.addEventListener('click', function () {
                            const subProductId = this.getAttribute('data-sub-product-id');
                            const productId = this.getAttribute('data-product-id'); // برای پیدا کردن input
                            const quantityInput = document.getElementById('quantity_' + productId);
                            const customerId = document.getElementById('customer_id').value;
                            const quantity = parseInt(quantityInput?.value); // استفاده از optional chaining

                            if (!customerId) {
                                alert('لطفاً مشتری را انتخاب کنید.');
                                return;
                            }

                            if (!quantityInput) {
                                alert('خطا: ورودی تعداد برای این محصول یافت نشد.');
                                return;
                            }

                            if (quantity >= 1 && !isNaN(quantity)) {
                                fetch('/admin/orders/add-to-order', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        customer_id: customerId,
                                        sub_product_id: subProductId,
                                        quantity: quantity
                                    })
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            document.getElementById('status_' + productId).classList.remove('d-none');
                                        } else {
                                            alert('خطا در افزودن محصول.');
                                        }
                                    })
                                    .catch(() => alert('مشکلی پیش آمده.'));
                            } else {
                                alert('تعداد معتبر وارد کنید.');
                            }
                        });
                    });


                    document.getElementById('add_order').addEventListener('submit', function (e) {
                        e.preventDefault();

                        const form = e.target;
                        const customerId = document.getElementById('customer_id').value;

                        if (!customerId) {
                            alert('لطفاً مشتری را انتخاب کنید.');
                            return;
                        }

                        // ساخت query string برای product_quantities
                        const params = new URLSearchParams();
                        document.querySelectorAll('.quantity-input').forEach(input => {
                            if (!input.disabled && input.value) {
                                const productId = input.name.match(/\d+/)[0];
                                params.append(`product_quantities[${productId}]`, input.value);
                            }
                        });

                        // انتقال به روت preview با ID مشتری و query string
                        window.location.href = `/admin/orders/preview/${customerId}?${params.toString()}`;
                    });
                });
            </script>

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

{{--    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>--}}
{{--    {!! JsValidator::formRequest('App\Http\Requests\Customer\CustomerRequest', '#add_order') !!}--}}

@endsection

