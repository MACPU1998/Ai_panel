@extends('admin.layouts.project-master')

@section('title', 'داشبورد')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="row flex-nowrap">
                <div class="col">
                    <div class="card warning-gradient">
                        <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="solar:recive-twice-square-linear"
                                              class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">آمار هوشمند</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                148</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card secondary-gradient">
                        <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="ic:outline-backpack" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">محصولات</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                156</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card danger-gradient">
                        <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="ic:baseline-sync-problem" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">انبار</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                64</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card success-gradient">
                        <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                                <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">فروش</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                                36,715 ريال</h4>
                            <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">جزئیات</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('customjs')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const map = L.map('map').setView([36.5659, 53.0586], 7);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
        window.onload = () => {
            chart('chartActiveDevices', 'success', "43, 38, 47, 31, 45, 30");
            chart('chartInactiveDevices', 'danger', "40, 50, 36, 40, 38, 43");
        };
    </script>
@endsection
