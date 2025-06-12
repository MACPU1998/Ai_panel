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

        </div>
    </div>
@endsection

