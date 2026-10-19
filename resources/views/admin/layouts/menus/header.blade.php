<header class="topbar">
    <div class="with-vertical">
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item d-flex d-xl-none">
                    <a class="nav-link nav-icon-hover-bg rounded-circle  sidebartoggler " id="headerCollapse"
                       href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-flex nav-icon-hover-bg rounded-circle">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="solar:magnifer-linear" class="fs-6"></iconify-icon>
                    </a>
                </li>
            </ul>

            <div class="d-block d-lg-none py-9 py-xl-0">
                <img src="{{ asset('assets/images/logos/logo.png')}}" alt="raykaio-logo" style="width: 45px;"/>
            </div>
            <a class="navbar-toggler p-0 border-0 nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
               data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
               aria-label="Toggle navigation">
                <iconify-icon icon="solar:menu-dots-bold-duotone" class="fs-6"></iconify-icon>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link moon dark-layout nav-icon-hover-bg rounded-circle"
                               href="javascript:void(0)">
                                <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                            </a>
                            <a class="nav-link sun light-layout nav-icon-hover-bg rounded-circle"
                               href="javascript:void(0)"
                               style="display: none">
                                <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                            </a>
                        </li>
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                               data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                            </a>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start language Dropdown -->
                        <!-- end language Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item position-relative">
                            <a id="cart-icon" class="nav-link nav-icon-hover-bg rounded-circle" href="#">
                                <iconify-icon icon="solar:cart-large-2-line-duotone" class="fs-5"></iconify-icon>
                                <span id="cart-count"
                                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">0
                                </span>

                            </a>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center gap-2 lh-base">
                                    <img src='{{asset("assets/images/profile/user-1.jpg")}}' class="rounded-circle"
                                         width="35" height="35"
                                         alt="matdash-img" id="topbar-avatar"/>
                                    <iconify-icon icon="solar:alt-arrow-down-bold" class="fs-2"></iconify-icon>
                                </div>
                            </a>
                            <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop1">
                                <div class="position-relative px-4 pt-3 pb-2">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                        <img src='{{asset("assets/images/profile/user-1.jpg")}}'
                                             class="rounded-circle" width="56" height="56"
                                             alt="matdash-img" id="header-avatar"/>
                                        <div>
                                            <h5 class="mb-0 fs-12">{{auth()->guard('admin')->user()->first_name}} {{auth()->guard('admin')->user()->last_name}}</h5>
                                            <p class="mb-0 text-dark">
                                                {{auth()->guard('admin')->user()->email}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">

                                        <a href="{{route('admin.edit')}}" class="p-2 dropdown-item h6 rounded-1">
                                            پروفایل من
                                        </a>
                                        <a href="{{route('admin.edit.password')}}"
                                           class="p-2 dropdown-item h6 rounded-1">
                                            تغییر رمز
                                        </a>
                                        <a href="javascript:void(0)" class="p-2 dropdown-item h6 rounded-1">
                                            تنظیمات
                                        </a>
                                        <form method="POST" action="{{ route('admin.logout') }}">
                                            @csrf
                                            <button type="submit" class="p-2 dropdown-item h6 rounded-1 w-100 text-start">
                                                خروج
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->

        <!-- ------------------------------- -->
        <!-- apps Dropdown in Small screen -->
        <!-- ------------------------------- -->
        <!--  Mobilenavbar -->
        <div class="offcanvas offcanvas-start pt-0" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
             aria-labelledby="offcanvasWithBothOptionsLabel">
            <nav class="sidebar-nav scroll-sidebar">
                <div class="offcanvas-header justify-content-between">
                    <a href="../main/index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/logo-icon.svg" alt="Logo"/>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-0" data-simplebar style="height: calc(100vh - 80px)">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow ms-0" href="javascript:void(0)" aria-expanded="false">
                      <span>
                        <iconify-icon icon="solar:slider-vertical-line-duotone" class="fs-7"></iconify-icon>
                      </span>
                                <span class="hide-menu">Apps</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level my-3 ps-3">
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-chat.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:chat-line-bold-duotone"
                                                          class="fs-7 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Chat Application</h6>
                                            <span class="fs-11 d-block text-body-color">New messages arrived</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-invoice.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:bill-list-bold-duotone"
                                                          class="fs-7 text-secondary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Invoice App</h6>
                                            <span class="fs-11 d-block text-body-color">Get latest invoice</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-contact2.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:phone-calling-rounded-bold-duotone"
                                                          class="fs-7 text-warning"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Contact Application</h6>
                                            <span class="fs-11 d-block text-body-color">2 Unsaved Contacts</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-email.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-danger-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:letter-bold-duotone"
                                                          class="fs-7 text-danger"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Email App</h6>
                                            <span class="fs-11 d-block text-body-color">Get new emails</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/page-user-profile.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-success-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:user-bold-duotone"
                                                          class="fs-7 text-success"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">User Profile</h6>
                                            <span class="fs-11 d-block text-body-color">learn more information</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-calendar.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:calendar-minimalistic-bold-duotone"
                                                          class="fs-7 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Calendar App</h6>
                                            <span class="fs-11 d-block text-body-color">Get dates</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-contact.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:smartphone-2-bold-duotone"
                                                          class="fs-7 text-secondary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Contact List Table</h6>
                                            <span class="fs-11 d-block text-body-color">Add new contact</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="sidebar-item py-2">
                                    <a href="../main/app-notes.html" class="d-flex align-items-center">
                                        <div
                                            class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                            <iconify-icon icon="solar:notes-bold-duotone"
                                                          class="fs-7 text-warning"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 bg-hover-primary">Notes Application</h6>
                                            <span class="fs-11 d-block text-body-color">To-do and Daily tasks</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item d-flex d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover-bg rounded-circle" id="sidebarCollapse"
                       href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-flex align-items-center">
                    <a href="../main/index.html" class="text-nowrap nav-link">
                        <img src="../assets/images/logos/logo.png" alt="matdash-img"/>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-flex align-items-center nav-icon-hover-bg rounded-circle">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="solar:magnifer-linear" class="fs-6"></iconify-icon>
                    </a>
                </li>
                <li class="nav-item d-none d-lg-flex align-items-center dropdown nav-icon-hover-bg rounded-circle">
                    <div class="hover-dd">
                        <a class="nav-link" id="drop2" href="javascript:void(0)" aria-haspopup="true"
                           aria-expanded="false">
                            <iconify-icon icon="solar:widget-3-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                        <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0 overflow-hidden"
                             aria-labelledby="drop2">
                            <div class="position-relative">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="p-4 pb-3">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="position-relative">
                                                        <a href="../main/app-chat.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:chat-line-bold-duotone"
                                                                              class="fs-7 text-primary"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Chat Application</h6>
                                                                <span class="fs-11 d-block text-body-color">New messages arrived</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-invoice.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:bill-list-bold-duotone"
                                                                              class="fs-7 text-secondary"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Invoice App</h6>
                                                                <span class="fs-11 d-block text-body-color">Get latest invoice</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-contact2.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon
                                                                    icon="solar:phone-calling-rounded-bold-duotone"
                                                                    class="fs-7 text-warning"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Contact Application</h6>
                                                                <span class="fs-11 d-block text-body-color">2 Unsaved Contacts</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-email.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-danger-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:letter-bold-duotone"
                                                                              class="fs-7 text-danger"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Email App</h6>
                                                                <span class="fs-11 d-block text-body-color">Get new emails</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative">
                                                        <a href="../main/page-user-profile.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-success-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:user-bold-duotone"
                                                                              class="fs-7 text-success"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">User Profile</h6>
                                                                <span class="fs-11 d-block text-body-color">learn more information</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-calendar.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon
                                                                    icon="solar:calendar-minimalistic-bold-duotone"
                                                                    class="fs-7 text-primary"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Calendar App</h6>
                                                                <span
                                                                    class="fs-11 d-block text-body-color">Get dates</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-contact.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:smartphone-2-bold-duotone"
                                                                              class="fs-7 text-secondary"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Contact List Table</h6>
                                                                <span class="fs-11 d-block text-body-color">Add new contact</span>
                                                            </div>
                                                        </a>
                                                        <a href="../main/app-notes.html"
                                                           class="d-flex align-items-center pb-9 position-relative">
                                                            <div
                                                                class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                <iconify-icon icon="solar:notes-bold-duotone"
                                                                              class="fs-7 text-warning"></iconify-icon>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">Notes Application</h6>
                                                                <span class="fs-11 d-block text-body-color">To-do and Daily tasks</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-none d-lg-flex">
                                        <img src="../assets/images/backgrounds/mega-dd-bg.jpg" alt="mega-dd"
                                             class="img-fluid mega-dd-bg"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="d-block d-xl-none">
                <a href="../main/index.html" class="text-nowrap nav-link">
                    <img src="../assets/images/logos/logo.png" alt="matdash-img"/>
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0 nav-icon-hover-bg rounded-circle"
               href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
               aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                    <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)"
                               class="nav-link nav-icon-hover-bg rounded-circle d-flex d-lg-none align-items-center justify-content-center"
                               type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                               aria-controls="offcanvasWithBothOptions">
                                <iconify-icon icon="solar:sort-line-duotone" class="fs-6"></iconify-icon>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover-bg rounded-circle moon dark-layout"
                               href="javascript:void(0)">
                                <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                            </a>
                            <a class="nav-link nav-icon-hover-bg rounded-circle sun light-layout"
                               href="javascript:void(0)"
                               style="display: none">
                                <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                            </a>
                        </li>
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                               data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                            </a>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start notification Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown nav-icon-hover-bg rounded-circle">
                            <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
                               aria-expanded="false">
                                <iconify-icon icon="solar:bell-bing-line-duotone" class="fs-6"></iconify-icon>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">اعلان ها</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">جدید 5  </span>
                                </div>
                                <div class="message-body" data-simplebar>
                                    <a href="javascript:void(0)"
                                       class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span
                              class="flex-shrink-0 bg-danger-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-danger">
                            <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                          </span>
                                        <div class="w-75">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-1 fw-semibold">Launch Admin</h6>
                                                <span class="d-block fs-2">9:30 AM</span>
                                            </div>
                                            <span class="d-block text-truncate text-truncate fs-11">Just see the my new admin!</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                       class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                          <span
                              class="flex-shrink-0 bg-primary-subtle rounded-circle round d-flex align-items-center justify-content-center fs-6 text-primary">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                          </span>
                                        <div class="w-75">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-1 fw-semibold">Event today</h6>
                                                <span class="d-block fs-2">9:15 AM</span>
                                            </div>
                                            <span class="d-block text-truncate text-truncate fs-11">Just a reminder that you have
                              event</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <button class="btn btn-primary w-100">دیدن تمام اعلانات</button>
                                </div>

                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end notification Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center gap-2 lh-base">
                                    <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="35"
                                         height="35"
                                         alt="matdash-img"/>
                                    <iconify-icon icon="solar:alt-arrow-down-bold" class="fs-2"></iconify-icon>
                                </div>
                            </a>
                            <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop1">
                                <div class="position-relative px-4 pt-3 pb-2">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                        <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="56"
                                             height="56"
                                             alt="matdash-img" id="topbar-avatar"/>
                                        <div>
                                            <h5 class="mb-0 fs-12">name</h5>
                                            <p class="mb-0 text-dark">
                                                email@email.com
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="p-2 dropdown-item h6 rounded-1">
                                            پروفایل من
                                        </a>
                                        <a href="javascript:void(0)" class="p-2 dropdown-item h6 rounded-1">
                                            تنظیمات
                                        </a>
                                        <a href="javascript:void(0)" class="p-2 dropdown-item h6 rounded-1">
                                            خروج
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</header>
