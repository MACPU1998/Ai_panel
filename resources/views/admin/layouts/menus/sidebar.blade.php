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
                                <iconify-icon icon="mdi-light:home"></iconify-icon>
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
                                <iconify-icon icon="mdi-light:account"></iconify-icon>
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
                            <li class="sidebar-item {{ $menus->where('parent_id', $parent->id)->count() ? 'has-submenu' : '' }}">
                                <a class="sidebar-link" href="{{ $parent->link ?? 'javascript:void(0)' }}"
                                   aria-expanded="false"
                                   onclick="toggleSubMenu(event, 'submenu-{{ $parent->id }}')">
                                    <iconify-icon icon="{{ $parent->icon }}"></iconify-icon>
                                    <span class="hide-menu">{{ $parent->title }}</span>
                                    @if($menus->where('parent_id', $parent->id)->count())
                                        <iconify-icon id="icon-{{ $parent->id }}" icon="solar:chevron-down-circle-line-duotone" class="submenu-toggle-icon"></iconify-icon>
                                    @endif
                                </a>

                                @if($menus->where('parent_id', $parent->id)->count())
                                    <ul class="sidebar-submenu" id="submenu-{{ $parent->id }}" style="display: none; opacity: 0; transition: opacity 0.3s ease;">
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

{{-- script for dynamic menu--}}
<script>
    function toggleSubMenu(event, submenuId) {
        event.preventDefault();
        let submenu = document.getElementById(submenuId);
        let icon = document.getElementById("icon-" + submenuId.replace("submenu-", ""));

        console.log("Toggling submenu:", submenuId); // چک کن که شناسه درست ارسال شده
        console.log("Icon element:", icon); // بررسی کن که آیکون درست انتخاب شده

        if (submenu.style.display === "none" || submenu.style.opacity === "0") {
            submenu.style.display = "block";
            setTimeout(() => {
                submenu.style.opacity = "1";
            }, 10);

            if (icon) {
                icon.setAttribute("icon", "solar:chevron-up-circle-line-duotone");
                console.log("Icon changed to up"); // تایید تغییر آیکون
            }
        } else {
            submenu.style.opacity = "0";
            setTimeout(() => {
                submenu.style.display = "none";
            }, 300);

            if (icon) {
                icon.setAttribute("icon", "solar:chevron-down-circle-line-duotone");
                console.log("Icon changed to down"); // تایید تغییر آیکون
            }
        }
    }
</script>


