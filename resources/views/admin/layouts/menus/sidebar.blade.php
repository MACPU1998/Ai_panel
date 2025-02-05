<!-- Sidebar Start -->
<aside class="side-mini-panel with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="iconbar">
        <div>
            <div class="mini-nav">
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </div>
                <ul class="mini-nav-ul" data-simplebar>

                    <!-- --------------------------------------------------------------------------------------------------------- -->
                    <!-- Dashboards -->
                    <!-- --------------------------------------------------------------------------------------------------------- -->
                    <li class="mini-nav-item" id="mini-1">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                           data-bs-placement="right" data-bs-title="داشبورد">
                            <iconify-icon icon="solar:layers-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <li>
                        <span class="sidebar-divider lg"></span>
                    </li>

                </ul>

            </div>
            <div class="sidebarmenu">
                <div class="brand-logo d-flex align-items-center nav-logo">
                    <a href="{{ url('workspace') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Logo" style="width:120px"/>
                    </a>

                </div>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
                    <ul class="sidebar-menu" id="sidebarnav">
                        <!-- ---------------------------------- -->
                        <!-- Home -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap">
                            <span class="hide-menu">داشبورد</span>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Dashboard -->
                        <!-- ---------------------------------- -->

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.dashboard')}}" aria-expanded="false">
                                <iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
                                <span class="hide-menu">داشبورد</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('menus.index')}}" aria-expanded="false">
                                <iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
                                <span class="hide-menu">مدیریت منوها</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('users.index')}}" aria-expanded="false">
                                <iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
                                <span class="hide-menu">مدیریت کاربران</span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('permissions.index')}}" aria-expanded="false">
                                <iconify-icon icon="solar:screencast-2-line-duotone"></iconify-icon>
                                <span class="hide-menu">مجوزها</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('roles.index')}}" aria-expanded="false">
                                <iconify-icon icon="solar:screencast-2-line-duotone"></iconify-icon>
                                <span class="hide-menu">نقش ها</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#" aria-expanded="false">
                                <iconify-icon icon="solar:screencast-2-line-duotone"></iconify-icon>
                                <span class="hide-menu">دسترسی ها</span>
                            </a>
                        </li>


                        <!-- داینامیک کردن منوها -->
                        @foreach($menus->where('parent_id', null) as $parent)
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ $parent->link }}" aria-expanded="false">
                                    <iconify-icon icon="{{ $parent->icon }}"></iconify-icon>
                                    <span class="hide-menu">{{ $parent->title }}</span>
                                </a>

                                @if($menus->where('parent_id', $parent->id)->count())
                                    <ul class="sidebar-submenu">
                                        @foreach($menus->where('parent_id', $parent->id) as $child)
                                            <li>
                                                <a href="{{ $child->link }}">
                                                    <iconify-icon icon="{{ $child->icon }}"></iconify-icon>
                                                    {{ $child->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#" aria-expanded="false">
                                <iconify-icon icon="et:documents"></iconify-icon>
                                <span class="hide-menu">انبار</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#" aria-expanded="false">
                                <iconify-icon icon=""></iconify-icon>
                                <span class="hide-menu">سفارشات</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" aria-expanded="false" href="#">
                                <iconify-icon icon=""></iconify-icon>
                                <span class="hide-menu">محصولات</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" aria-expanded="false" href="#">
                                <iconify-icon icon=""></iconify-icon>
                                <span class="hide-menu">آمار هوشمند</span>
                            </a>
                        </li>


                        <li>
                            <span class="sidebar-divider"></span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</aside>
<!--  Sidebar End -->
