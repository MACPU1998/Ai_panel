<!DOCTYPE html>
<html lang="en" dir="rtl" data-bs-theme="light" data-color-theme="Orange_Theme" data-layout="vertical">

<head>
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/JeremyFagis/dropify@master/dist/css/dropify.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.ico') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <title>@yield('title')</title>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- end Preloader -->

    <div id="main-wrapper">

        @include('admin.layouts.menus.sidebar')

        <div class="page-wrapper">
            <!--  Header Start -->
            @include('admin.layouts.menus.header')

            <!--end header -->
            <!--search Bar -->
            @include('admin.layouts.menus.searchbar')

            <!--end Search Bar-->
            <!--  Header End -->

            @include('admin.layouts.menus.topbar')




            <!-- content -->
            <div class="body-wrapper">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>
            <!-- end content-->

            <!--btn setting-->
{{--            @include('layouts.menus.setting')--}}
            <!--end btn setting-->

        </div>
    </div>

    <!-- script -->

    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
{{--    Toastify--}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!--end script-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <!-- Custom scripts pushed from specific pages -->
    @stack('scripts')

    <!-- custom js -->
    @yield('customjs')
    <!-- end coustom js-->

    <!-- Dropify JS -->
    <script src="https://cdn.jsdelivr.net/gh/JeremyFagis/dropify@master/dist/js/dropify.min.js"></script>

</body>

</html>
