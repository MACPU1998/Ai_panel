@extends('admin.layouts.project_master_admin')

@section('title', 'صندوق فروش')

@section('content')

    <style>
        /* ── Grid: سبد عریض‌تر، جستجو باریک‌تر ── */
        #cashier-wrap {
            display: grid;
            grid-template-columns: 520px 1fr;
            grid-template-rows: auto 1fr;
            gap: 14px;
            height: calc(100vh - 160px);
            min-height: 580px;
        }

        #customer-panel {
            grid-column: 1 / -1;
        }

        /* ── ستون‌ها ── */
        #cart-panel {
            display: flex;
            flex-direction: column;
        }

        #product-panel {
            overflow-y: auto;
        }

        #cart-items {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 420px);
            min-height: 200px;
        }

        /* ─ آیتم سبد ─ */
        .cart-item {
            border-bottom: 1px solid #f0f0f0;
            padding: 12px 14px;
            transition: background .1s;
        }

        .cart-item:hover {
            background: #fafafa;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item .item-name {
            font-size: .93rem;
            font-weight: 600;
        }

        .cart-item .item-price {
            font-size: .78rem;
            color: #6c757d;
        }

        .cart-item .item-total {
            font-size: .88rem;
            font-weight: 700;
            color: #198754;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            line-height: 1;
            font-size: 1rem;
        }

        /* ── نتایج جستجو ── */
        .product-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 10px;
            border-bottom: 1px solid #f0f0f0;
            cursor: default;
            transition: background .12s;
        }

        .product-row:last-child {
            border-bottom: none;
        }

        .product-row:hover {
            background: #f8f9fa;
        }

        .product-row .p-thumb {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-row .p-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-row .p-info {
            flex: 1;
            min-width: 0;
        }

        .product-row .p-name {
            font-size: .85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-row .p-meta {
            font-size: .75rem;
            color: #6c757d;
        }

        .product-row .p-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        .product-row .qty-field {
            width: 52px !important;
            text-align: center;
        }

        /* ── بارکد ── */
        #barcode-input {
            border: 2px dashed #ffc107;
            background: #fffdf0;
        }

        #barcode-input:focus {
            border-color: #198754;
            background: #fff;
        }

        /* ── پنل پرداخت ── */
        #payment-section {
            border-top: 2px solid #dee2e6;
            padding: 12px 14px;
            background: #f8f9fa;
        }

        .payment-method-btn {
            flex: 1;
            padding: 8px 4px;
            font-size: .82rem;
            border: 2px solid #dee2e6;
            background: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: all .15s;
        }

        .payment-method-btn.active {
            border-color: #198754;
            background: #e8f5e9;
            color: #198754;
            font-weight: 600;
        }

        /* ── منو collapsible ── */
        .product-search-header {
            cursor: pointer;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 2px;
            margin-bottom: 4px;
        }

        .product-search-header .toggle-icon {
            transition: transform .2s;
        }

        .product-search-header.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }

        .collapsible-body {
            overflow: hidden;
            transition: max-height .25s ease;
        }

        /* ── Toast ── */
        .pos-toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            padding: 10px 24px;
            border-radius: 24px;
            font-size: .9rem;
            z-index: 9999;
            opacity: 0;
            transition: opacity .3s;
            pointer-events: none;
        }

        .pos-toast.show {
            opacity: 1;
        }
    </style>

    <div id="cashier-wrap">

        {{-- ══════ ردیف بالا: مشتری ══════ --}}
        <div id="customer-panel" class="card p-2">
            <div class="row g-2 align-items-center">

                <div class="col-md-5">
                    <label class="form-label fw-semibold mb-1 small">
                        <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                        انتخاب مشتری
                    </label>
                    <div class="position-relative" id="customer-field-wrap">
                        <div id="customer-search-wrap" class="input-group">
                            <input type="text" id="customer-search-input" class="form-control"
                                   placeholder="نام، نام‌خانوادگی یا شماره تلفن...">
                        </div>
                        <div id="selected-customer-badge" class="d-none input-group">
                            <div class="form-control d-flex align-items-center gap-2"
                                 style="background:#e8f5e9;border-color:#a5d6a7;cursor:default;height:auto;min-height:38px;">
                                <iconify-icon icon="solar:check-circle-bold"
                                              style="color:#198754;font-size:1rem;flex-shrink:0;"></iconify-icon>
                                <div class="lh-sm flex-fill overflow-hidden">
                                    <div class="fw-semibold text-success text-truncate small"
                                         id="selected-customer-name"></div>
                                    <div class="text-muted" style="font-size:.73rem;"
                                         id="selected-customer-phone"></div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary" type="button"
                                    id="btn-clear-customer" title="تغییر مشتری">
                                <iconify-icon icon="solar:pen-2-line-duotone"></iconify-icon>
                            </button>
                        </div>
                        <div id="customer-search-results" class="list-group position-absolute z-3 shadow"
                             style="width:100%;display:none;max-height:200px;overflow-y:auto;top:100%;right:0;"></div>
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <span class="text-muted small"> </span>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold mb-1 small">
                        <iconify-icon icon="solar:user-plus-bold-duotone"></iconify-icon>
                        ثبت مشتری جدید
                    </label>
                    <button class="btn btn-outline-primary w-100 btn-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#modal-new-customer">
                        <iconify-icon icon="solar:add-circle-line-duotone"></iconify-icon>
                        ثبت مشتری جدید
                    </button>
                </div>

            </div>
        </div>

        {{-- ══════ ستون چپ: سبد خرید (عریض) ══════ --}}
        <div id="cart-panel" class="card">

            <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
            <span class="fw-bold">
                <iconify-icon icon="solar:cart-large-4-bold-duotone"></iconify-icon>
                سبد خرید
            </span>
                <span class="badge bg-secondary" id="cart-count">۰ آیتم</span>
            </div>

            <div id="cart-items">
                <div id="cart-empty" class="text-center text-muted py-5">
                    <iconify-icon icon="solar:cart-cross-bold-duotone" style="font-size:3rem"></iconify-icon>
                    <p class="mt-2 small">سبد خالی است</p>
                </div>
            </div>

            <div id="payment-section">
                <div class="d-flex justify-content-between mb-2 fw-bold fs-6">
                    <span>جمع کل:</span>
                    <span id="cart-total" class="text-success">۰ تومان</span>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold small mb-1">روش پرداخت</label>
                    <div class="d-flex gap-2">
                        <button class="payment-method-btn active" data-method="cash">
                            <iconify-icon icon="solar:banknote-bold-duotone"></iconify-icon>
                            <br>نقدی
                        </button>
                        <button class="payment-method-btn" data-method="card">
                            <iconify-icon icon="solar:card-bold-duotone"></iconify-icon>
                            <br>کارت
                        </button>
                        <button class="payment-method-btn" data-method="mixed">
                            <iconify-icon icon="solar:card-transfer-bold-duotone"></iconify-icon>
                            <br>ترکیبی
                        </button>
                    </div>
                </div>

                <div id="mixed-amounts" class="row g-2 mb-2" style="display:none!important">
                    <div class="col-6">
                        <label class="form-label small mb-1">مبلغ نقدی</label>
                        <input type="number" id="cash-amount" class="form-control form-control-sm"
                               placeholder="تومان" min="0" value="0">
                    </div>
                    <div class="col-6">
                        <label class="form-label small mb-1">مبلغ کارت</label>
                        <input type="number" id="card-amount" class="form-control form-control-sm"
                               placeholder="تومان" min="0" value="0">
                    </div>
                    <div class="col-12">
                        <small id="mixed-diff" class="text-danger"></small>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <button id="btn-checkout" class="btn btn-success flex-fill fw-bold" disabled>
                        <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                        ثبت و پرداخت
                    </button>
                    <button id="btn-clear-cart" class="btn btn-outline-danger" title="پاک کردن سبد">
                        <iconify-icon icon="solar:trash-bin-2-bold-duotone"></iconify-icon>
                    </button>
                </div>
            </div>

        </div>

        {{-- ══════ ستون راست: جستجو + محصولات (باریک) ══════ --}}
        <div id="product-panel" class="card p-2">

            {{-- ── بخش جستجو — با قابلیت باز/بسته ── --}}
            <div id="search-section">
                <div class="product-search-header" id="search-toggle">
                <span class="fw-semibold small">
                    <iconify-icon icon="solar:magnifer-bold-duotone"></iconify-icon>
                    جستجو
                </span>
                    <iconify-icon icon="solar:alt-arrow-down-line-duotone"
                                  class="toggle-icon text-muted"></iconify-icon>
                </div>
                <div class="collapsible-body" id="search-body" style="max-height:200px;">
                    <div class="d-flex gap-2">
                        <input type="text" id="product-search-input" class="form-control form-control-sm"
                               placeholder="نام محصول...">
                        <input type="text" id="barcode-input" class="form-control form-control-sm"
                               placeholder="بارکد..." style="max-width:140px;">
                    </div>
                </div>
            </div>

            <hr class="my-2">

            {{-- ── نتایج جستجو — لیست مینیمال ── --}}
            <div id="product-results" style="overflow-y:auto; flex:1;">
                <div class="text-center text-muted py-4" id="search-placeholder">
                    <iconify-icon icon="solar:box-minimalistic-line-duotone" style="font-size:2.5rem"></iconify-icon>
                    <p class="mt-1 small">جستجو کنید یا بارکد اسکن نمایید.</p>
                </div>
            </div>

        </div>

    </div>{{-- /cashier-wrap --}}

    {{-- Modal: مشتری جدید --}}
    <div class="modal fade" id="modal-new-customer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ثبت مشتری جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="new-customer-error" class="alert alert-danger d-none"></div>
                    <div class="mb-3">
                        <label class="form-label">نام <span class="text-danger">*</span></label>
                        <input type="text" id="nc-first-name" class="form-control" placeholder="نام">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نام خانوادگی <span class="text-danger">*</span></label>
                        <input type="text" id="nc-last-name" class="form-control" placeholder="نام خانوادگی">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">شماره تلفن <span class="text-danger">*</span></label>
                        <input type="text" id="nc-phone" class="form-control" placeholder="09xxxxxxxxx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" id="btn-save-customer" class="btn btn-primary">ثبت مشتری</button>
                </div>
            </div>
        </div>
    </div>

    <div class="pos-toast" id="pos-toast"></div>

@endsection

@section('customjs')
    <script>
        (function () {
            'use strict';

            // ── State ──────────────────────────────────────────
            let state = {
                customerId: null,
                orderId: null,
                cart: null,
                paymentMethod: 'cash',
            };

            const CSRF = document.querySelector('meta[name="csrf-token"]').content;

            // ── DOM refs ────────────────────────────────────────
            const $productSearch = document.getElementById('product-search-input');
            const $barcodeInput = document.getElementById('barcode-input');
            const $productResults = document.getElementById('product-results');
            const $cartItems = document.getElementById('cart-items');
            const $cartEmpty = document.getElementById('cart-empty');
            const $cartCount = document.getElementById('cart-count');
            const $cartTotal = document.getElementById('cart-total');
            const $btnCheckout = document.getElementById('btn-checkout');
            const $btnClearCart = document.getElementById('btn-clear-cart');
            const $customerInput = document.getElementById('customer-search-input');
            const $customerResults = document.getElementById('customer-search-results');
            const $selectedBadge = document.getElementById('selected-customer-badge');
            const $selectedName = document.getElementById('selected-customer-name');
            const $selectedPhone = document.getElementById('selected-customer-phone');
            const $mixedAmounts = document.getElementById('mixed-amounts');
            const $cashAmount = document.getElementById('cash-amount');
            const $cardAmount = document.getElementById('card-amount');
            const $mixedDiff = document.getElementById('mixed-diff');

            // ══════════════════════════════════════════════════
            //  Toast
            // ══════════════════════════════════════════════════
            function toast(msg, type = 'success') {
                const el = document.getElementById('pos-toast');
                el.textContent = msg;
                el.style.background = type === 'success' ? '#198754' : '#dc3545';
                el.classList.add('show');
                setTimeout(() => el.classList.remove('show'), 2800);
            }

            // ══════════════════════════════════════════════════
            //  Helpers
            // ══════════════════════════════════════════════════
            function formatPrice(n) {
                return Number(n).toLocaleString('fa-IR') + ' تومان';
            }

            function debounce(fn, ms) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), ms);
                };
            }

            // ══════════════════════════════════════════════════
            //  Collapse / Expand بخش جستجو
            // ══════════════════════════════════════════════════
            const $searchToggle = document.getElementById('search-toggle');
            const $searchBody = document.getElementById('search-body');
            let searchOpen = true;

            $searchToggle.addEventListener('click', () => {
                searchOpen = !searchOpen;
                if (searchOpen) {
                    $searchBody.style.maxHeight = $searchBody.scrollHeight + 'px';
                    $searchToggle.classList.remove('collapsed');
                } else {
                    $searchBody.style.maxHeight = '0';
                    $searchToggle.classList.add('collapsed');
                }
            });

            // ══════════════════════════════════════════════════
            //  جستجوی مشتری
            // ══════════════════════════════════════════════════
            const searchCustomers = debounce(async function (q) {
                if (q.length < 1) {
                    $customerResults.style.display = 'none';
                    return;
                }
                const res = await fetch(`{{ route('cashier.search_customers') }}?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                renderCustomerResults(data);
            }, 300);

            $customerInput.addEventListener('input', e => searchCustomers(e.target.value));

            function renderCustomerResults(list) {
                $customerResults.innerHTML = !list.length
                    ? '<a class="list-group-item text-muted small">نتیجه‌ای یافت نشد.</a>'
                    : list.map(c => `
                <a class="list-group-item list-group-item-action d-flex justify-content-between"
                   href="#" data-id="${c.id}"
                   data-name="${c.first_name} ${c.last_name}" data-phone="${c.phone}">
                    <span class="small">${c.first_name} ${c.last_name}</span>
                    <small class="text-muted">${c.phone}</small>
                </a>`).join('');
                $customerResults.style.display = 'block';
            }

            $customerResults.addEventListener('click', async e => {
                e.preventDefault();
                const item = e.target.closest('[data-id]');
                if (!item) return;
                await selectCustomer(item.dataset.id, item.dataset.name, item.dataset.phone);
            });

            async function selectCustomer(id, name, phone) {
                state.customerId = id;
                $selectedName.textContent = name;
                $selectedPhone.textContent = phone;
                document.getElementById('customer-search-wrap').classList.add('d-none');
                $selectedBadge.classList.remove('d-none');
                $customerInput.value = '';
                $customerResults.style.display = 'none';
                await loadCart(id);
            }

            document.getElementById('btn-clear-customer').addEventListener('click', () => {
                state.customerId = null;
                state.orderId = null;
                state.cart = null;
                $selectedBadge.classList.add('d-none');
                document.getElementById('customer-search-wrap').classList.remove('d-none');
                $customerInput.value = '';
                $customerInput.focus();
                renderCart(null);
            });

            document.addEventListener('click', e => {
                if (!e.target.closest('#customer-field-wrap')) $customerResults.style.display = 'none';
            });

            // ══════════════════════════════════════════════════
            //  جستجوی محصول
            // ══════════════════════════════════════════════════
            const searchProducts = debounce(async function (q) {
                if (q.length < 1) {
                    $productResults.innerHTML = `
                <div class="text-center text-muted py-4">
                    <iconify-icon icon="solar:box-minimalistic-line-duotone" style="font-size:2.5rem"></iconify-icon>
                    <p class="mt-1 small">جستجو کنید یا بارکد اسکن نمایید.</p>
                </div>`;
                    return;
                }
                const res = await fetch(`{{ route('cashier.search_products') }}?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                renderProductResults(data);
            }, 350);

            $productSearch.addEventListener('input', e => searchProducts(e.target.value));

            $barcodeInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchProducts($barcodeInput.value.trim());
                }
            });
            $barcodeInput.addEventListener('input', debounce(e => {
                if (e.target.value.trim()) searchProducts(e.target.value.trim());
            }, 600));

            function renderProductResults(list) {
                if (!list.length) {
                    $productResults.innerHTML = `
                <div class="text-center text-muted py-4">
                    <iconify-icon icon="solar:box-minimalistic-broken" style="font-size:2rem"></iconify-icon>
                    <p class="mt-1 small">محصولی یافت نشد.</p>
                </div>`;
                    return;
                }

                const rows = list.map(p => `
            <div class="product-row" data-product-id="${p.id}">
                <div class="p-thumb">
                    ${p.image ? `<img src="${p.image}" alt="${p.name}">` : '<iconify-icon icon="solar:box-line-duotone" style="font-size:1.2rem;color:#aaa;"></iconify-icon>'}
                </div>
                <div class="p-info">
                    <div class="p-name" title="${p.name}">${p.name}</div>
                    <div class="p-meta">
                        ${Number(p.price).toLocaleString('fa-IR')} ت
                        &nbsp;·&nbsp; موجودی: ${p.stock}
                        ${p.barcode ? `&nbsp;·&nbsp; 🔖${p.barcode}` : ''}
                    </div>
                </div>
                <div class="p-actions">
                    <input type="number" class="form-control form-control-sm qty-field"
                           value="1" min="1" max="${p.stock}">
                    <button class="btn btn-sm btn-success btn-add-product px-2">+</button>
                </div>
            </div>`).join('');

                $productResults.innerHTML = `<div class="border rounded">${rows}</div>`;
            }

            $productResults.addEventListener('click', async e => {
                const btn = e.target.closest('.btn-add-product');
                if (!btn) return;
                if (!state.customerId) {
                    toast('ابتدا مشتری را انتخاب کنید.', 'error');
                    return;
                }

                const row = btn.closest('.product-row');
                const qtyEl = row.querySelector('.qty-field');
                const qty = parseInt(qtyEl.value) || 1;
                const productId = row.dataset.productId;
                const pName = row.querySelector('.p-name').textContent;

                btn.disabled = true;
                btn.textContent = '…';
                try {
                    const res = await postJSON('{{ route('cashier.add_to_cart') }}', {
                        customer_id: state.customerId,
                        product_id: productId,
                        quantity: qty,
                    });
                    if (res.success) {
                        toast(`"${pName}" به سبد اضافه شد.`);
                        applyCart(res.cart);
                    } else {
                        toast(res.message || 'خطا در افزودن.', 'error');
                    }
                } catch (_) {
                    toast('خطای ارتباطی.', 'error');
                }
                btn.disabled = false;
                btn.textContent = '+';
            });

            // ══════════════════════════════════════════════════
            //  سبد خرید
            // ══════════════════════════════════════════════════
            async function loadCart(customerId) {
                try {
                    const res = await fetch(`/admin/cashier/cart/${customerId}`);
                    const data = await res.json();
                    if (data.success) applyCart(data.cart);
                } catch (_) {
                }
            }

            function applyCart(cart) {
                state.cart = cart;
                state.orderId = cart?.order_id ?? null;
                renderCart(cart);
            }

            function renderCart(cart) {
                if (!cart || !cart.items || cart.items.length === 0) {
                    $cartEmpty.style.display = 'block';
                    $cartItems.querySelectorAll('.cart-item').forEach(el => el.remove());
                    $cartCount.textContent = '۰ آیتم';
                    $cartTotal.textContent = '۰ تومان';
                    $btnCheckout.disabled = true;
                    return;
                }

                $cartEmpty.style.display = 'none';
                $cartCount.textContent = cart.items.length + ' آیتم';
                $cartTotal.textContent = formatPrice(cart.final_price);
                $cartItems.querySelectorAll('.cart-item').forEach(el => el.remove());

                cart.items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'cart-item';
                    div.dataset.itemId = item.id;
                    div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-fill me-2 overflow-hidden">
                        <div class="item-name text-truncate" title="${item.product_name}">${item.product_name}</div>
                        <div class="item-price">${Number(item.price).toLocaleString('fa-IR')} تومان / واحد</div>
                    </div>
                    <button class="btn btn-sm btn-link text-danger p-0 btn-remove-item" title="حذف">
                        <iconify-icon icon="solar:trash-bin-2-bold-duotone" style="font-size:1.1rem;"></iconify-icon>
                    </button>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2">
                    <div class="d-flex align-items-center gap-1">
                        <button class="btn btn-outline-secondary qty-btn btn-dec">−</button>
                        <input type="number" class="form-control form-control-sm text-center qty-input"
                               value="${item.quantity}" min="1" max="${item.stock}" style="width:54px">
                        <button class="btn btn-outline-secondary qty-btn btn-inc">+</button>
                    </div>
                    <span class="item-total">${Number(item.total_price).toLocaleString('fa-IR')} ت</span>
                </div>`;
                    $cartItems.appendChild(div);
                });

                $btnCheckout.disabled = !state.customerId;
                updateMixedDiff();
            }

            $cartItems.addEventListener('click', async e => {
                const item = e.target.closest('.cart-item');
                if (!item) return;
                const qtyInput = item.querySelector('.qty-input');

                if (e.target.closest('.btn-dec')) {
                    const v = parseInt(qtyInput.value) - 1;
                    if (v < 1) return;
                    qtyInput.value = v;
                    await updateItem(item.dataset.itemId, v);
                }
                if (e.target.closest('.btn-inc')) {
                    const v = parseInt(qtyInput.value) + 1;
                    qtyInput.value = v;
                    await updateItem(item.dataset.itemId, v);
                }
                if (e.target.closest('.btn-remove-item')) {
                    await removeItem(item.dataset.itemId);
                }
            });

            $cartItems.addEventListener('change', async e => {
                if (!e.target.classList.contains('qty-input')) return;
                const item = e.target.closest('.cart-item');
                const v = Math.max(1, parseInt(e.target.value) || 1);
                e.target.value = v;
                await updateItem(item.dataset.itemId, v);
            });

            async function updateItem(itemId, qty) {
                if (!state.orderId) return;
                try {
                    const res = await postJSON('{{ route('cashier.update_cart_item') }}', {
                        order_id: state.orderId, item_id: itemId, quantity: qty,
                    });
                    if (res.success) applyCart(res.cart);
                    else toast(res.message || 'خطا.', 'error');
                } catch (_) {
                    toast('خطای ارتباطی.', 'error');
                }
            }

            async function removeItem(itemId) {
                if (!state.orderId) return;
                try {
                    const res = await deleteJSON('{{ route('cashier.remove_cart_item') }}', {
                        order_id: state.orderId, item_id: itemId,
                    });
                    if (res.success) applyCart(res.cart);
                    else toast(res.message || 'خطا.', 'error');
                } catch (_) {
                    toast('خطای ارتباطی.', 'error');
                }
            }

            $btnClearCart.addEventListener('click', async () => {
                if (!state.cart?.items?.length) return;
                if (!confirm('آیا مطمئنید؟ تمام آیتم‌های سبد پاک می‌شوند.')) return;
                for (const item of [...state.cart.items]) await removeItem(item.id);
            });

            // ══════════════════════════════════════════════════
            //  روش پرداخت
            // ══════════════════════════════════════════════════
            document.querySelectorAll('.payment-method-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.payment-method-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    state.paymentMethod = this.dataset.method;
                    $mixedAmounts.style.setProperty('display', state.paymentMethod === 'mixed' ? 'flex' : 'none', 'important');
                    updateMixedDiff();
                });
            });

            function updateMixedDiff() {
                if (state.paymentMethod !== 'mixed' || !state.cart) {
                    $mixedDiff.textContent = '';
                    return;
                }
                const total = state.cart.final_price;
                const sum = (parseFloat($cashAmount.value) || 0) + (parseFloat($cardAmount.value) || 0);
                const diff = sum - total;
                $mixedDiff.textContent = Math.abs(diff) < 1 ? '' :
                    (diff < 0 ? `کمبود: ${Math.abs(diff).toLocaleString('fa-IR')} تومان`
                        : `اضافه: ${diff.toLocaleString('fa-IR')} تومان`);
            }

            [$cashAmount, $cardAmount].forEach(el => el.addEventListener('input', updateMixedDiff));

            // ══════════════════════════════════════════════════
            //  ثبت و پرداخت
            // ══════════════════════════════════════════════════
            $btnCheckout.addEventListener('click', async () => {
                if (!state.orderId) {
                    toast('سبد خالی است.', 'error');
                    return;
                }
                if (!state.customerId) {
                    toast('مشتری انتخاب نشده.', 'error');
                    return;
                }

                const payload = {order_id: state.orderId, payment_method: state.paymentMethod};
                if (state.paymentMethod === 'mixed') {
                    payload.cash_amount = parseFloat($cashAmount.value) || 0;
                    payload.card_amount = parseFloat($cardAmount.value) || 0;
                }

                $btnCheckout.disabled = true;
                $btnCheckout.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>در حال ثبت...';

                try {
                    const res = await postJSON('{{ route('cashier.checkout') }}', payload);
                    if (res.success) {
                        toast('✅ سفارش با موفقیت ثبت شد!');
                        state.orderId = null;
                        state.cart = null;
                        renderCart(null);
                        if (confirm('سفارش ثبت شد.\nآیا می‌خواهید رسید را مشاهده کنید؟'))
                            window.open(res.receipt_url, '_blank');
                    } else {
                        toast(res.message || 'خطا در ثبت.', 'error');
                    }
                } catch (_) {
                    toast('خطای ارتباطی.', 'error');
                }

                $btnCheckout.disabled = false;
                $btnCheckout.innerHTML = '<iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon> ثبت و پرداخت';
            });

            // ══════════════════════════════════════════════════
            //  ثبت مشتری جدید (Modal)
            // ══════════════════════════════════════════════════
            document.getElementById('btn-save-customer').addEventListener('click', async function () {
                const firstName = document.getElementById('nc-first-name').value.trim();
                const lastName = document.getElementById('nc-last-name').value.trim();
                const phone = document.getElementById('nc-phone').value.trim();
                const errEl = document.getElementById('new-customer-error');
                errEl.classList.add('d-none');

                if (!firstName || !lastName || !phone) {
                    errEl.textContent = 'لطفاً تمام فیلدها را پر کنید.';
                    errEl.classList.remove('d-none');
                    return;
                }

                this.disabled = true;
                try {
                    const res = await postJSON('{{ route('cashier.register_customer') }}', {
                        first_name: firstName, last_name: lastName, phone,
                    });
                    if (res.success) {
                        bootstrap.Modal.getInstance(document.getElementById('modal-new-customer')).hide();
                        await selectCustomer(res.customer.id,
                            res.customer.first_name + ' ' + res.customer.last_name,
                            res.customer.phone);
                        toast('مشتری با موفقیت ثبت شد.');
                        ['nc-first-name', 'nc-last-name', 'nc-phone'].forEach(id => document.getElementById(id).value = '');
                    } else {
                        const msgs = res.errors ? Object.values(res.errors).flat().join('<br>') : res.message;
                        errEl.innerHTML = msgs;
                        errEl.classList.remove('d-none');
                    }
                } catch (_) {
                    errEl.textContent = 'خطای ارتباطی.';
                    errEl.classList.remove('d-none');
                }
                this.disabled = false;
            });

            // ══════════════════════════════════════════════════
            //  HTTP helpers
            // ══════════════════════════════════════════════════
            async function postJSON(url, data) {
                const r = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF},
                    body: JSON.stringify(data),
                });
                return r.json();
            }

            async function deleteJSON(url, data) {
                const r = await fetch(url, {
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF},
                    body: JSON.stringify(data),
                });
                return r.json();
            }

        })();
    </script>
@endsection
