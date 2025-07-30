@extends('admin.layouts.project_master_admin')

@section('title', 'داشبورد')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{--            @dd(auth()->guard())--}}
            {{--            @dd(Auth::guard('admin')->check());--}}

            <div class="row flex-nowrap">
                <div class="col">
                    <div class="card custom-card">
                        <div class="card-body text-center px-9 pb-4">
                            <div
                                class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="solar:recive-twice-square-linear"
                                              class="fs-7 text-dark"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">آمار هوشمند</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                148</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card custom-card">
                        <div class="card-body text-center px-9 pb-4">
                            <div
                                class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="ic:outline-backpack"
                                              class="fs-7 text-dark"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">محصولات</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                56</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card custom-card">
                        <div class=" card-body text-center px-9 pb-4 ">
                            <div
                                class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="material-symbols:warehouse-outline-rounded"
                                              class="fs-7 text-dark"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">انبار</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                8</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card custom-card">
                        <div class="card-body text-center px-9 pb-4">
                            <div
                                class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="iconamoon:shopping-bag-light"
                                              class="fs-7 text-dark"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">فروش</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                               37.455 تومان</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row flex-nowrap">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="card-title">Revenue Forecast</h5>
                                <p class="card-subtitle mb-0">Overview of Profit</p>
                            </div>

                            <div class="hstack gap-9 mt-4 mt-md-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-10 bg-primary rounded-circle"></span>
                                    <span class="text-nowrap text-muted">2024</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-block flex-shrink-0 round-10 bg-danger rounded-circle"></span>
                                    <span class="text-nowrap text-muted">2023</span>
                                </div>
                            </div>
                        </div>
                        <div style="height: 305px;" class="me-n2 rounded-bars">
                            <div id="revenue-forecast"></div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="col-md-4">
                                <div class="hstack gap-6 mb-3 mb-md-0">
                        <span class="d-flex align-items-center justify-content-center round-48 bg-light rounded">
                          <iconify-icon icon="solar:pie-chart-2-linear" class="fs-7 text-dark"></iconify-icon>
                        </span>
                                    <div>
                                        <span>Total</span>
                                        <h5 class="mt-1 fw-medium mb-0">$96,640</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hstack gap-6 mb-3 mb-md-0">
                        <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded">
                          <iconify-icon icon="solar:dollar-minimalistic-linear" class="fs-7 text-primary"></iconify-icon>
                        </span>
                                    <div>
                                        <span>Profit</span>
                                        <h5 class="mt-1 fw-medium mb-0">$48,820</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hstack gap-6">
                        <span class="d-flex align-items-center justify-content-center round-48 bg-danger-subtle rounded">
                          <iconify-icon icon="solar:database-linear" class="fs-7 text-danger"></iconify-icon>
                        </span>
                                    <div>
                                        <span>Earnings</span>
                                        <h5 class="mt-1 fw-medium mb-0">$48,820</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">خلاصه گزارش</h5>
                        <div class="bg-primary-subtle rounded overflow-hidden mb-4">
                            <div class="p-4 mb-7">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted">Conversion Rate</span>
                                    <h4 class="mb-0">18.4%</h4>
                                </div>
                            </div>
                            <div id="annual-profit"></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pb-6 border-bottom">
                            <div>
                                <span class="text-muted fw-medium">تعداد کل مشتریان</span>
                                <span class="fs-11 fw-medium d-block mt-1">مشتریانی که امروز ثبت نام کردند</span>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bolder mb-1">0</h6>
                                <span class="fs-11 fw-medium text-success">2</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between py-6 border-bottom">
                            <div>
                                <span class="text-muted fw-medium">تعداد کل سفارشات</span>
                                <span class="fs-11 fw-medium d-block mt-1">سفارشات در حال پرداخت</span>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bolder mb-1">15</h6>
                                <span class="fs-11 fw-medium text-success">2</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-6">
                            <div>
                                <span class="text-muted fw-medium">تعداد محصولات</span>
                                <span class="fs-11 fw-medium d-block mt-1">تعداد زیر محصول</span>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bolder mb-1">200</h6>
                                <span class="fs-11 fw-medium text-success">8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

