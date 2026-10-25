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
                                <iconify-icon icon="hugeicons:home-09"></iconify-icon>
                                <span class="hide-menu">{{__("general.dashboard")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('menus.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi-light:menu"></iconify-icon>
                                <span class="hide-menu">{{__("general.manage_menu")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admins.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi:shield-account"></iconify-icon>
                                <span class="hide-menu">{{__("general.manage_admin")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('users.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi-light:account"></iconify-icon>
                                <span class="hide-menu">{{__("general.manage_user")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('warehouses.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi:warehouse"></iconify-icon>
                                <span class="hide-menu">{{__("general.manage_warehouse")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('customers.index')}}" aria-expanded="false">
                                <iconify-icon icon="carbon:user"></iconify-icon>
                                <span class="hide-menu">{{__("general.manage_customer")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('cashier.index')}}" aria-expanded="false">
                                <iconify-icon icon="solar:cash-out-bold-duotone"></iconify-icon>
                                <span class="hide-menu">{{__("general.cashier_pos")}}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('orders.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi-light:cart"></iconify-icon>
                                <span class="hide-menu">{{__("general.order")}}</span>
                            </a>
                        </li>


                        {{-- Role & Permission Group --}}
                        <li class="sidebar-item has-submenu" id="menu-item-role-permission">
                            <a class="sidebar-link" href="javascript:void(0)" aria-expanded="false"
                               onclick="toggleSubMenu(event, 'submenu-role-permission')">
                                <iconify-icon icon="solar:shield-keyhole-minimalistic-line-duotone"></iconify-icon>
                                <span class="hide-menu">{{__("general.role_permission_management")}}</span>
                                <iconify-icon id="icon-role-permission"
                                              icon="solar:chevron-down-circle-line-duotone"
                                              class="submenu-toggle-icon"></iconify-icon>
                            </a>
                            <ul class="sidebar-submenu mt-3" id="submenu-role-permission"
                                style="display: none; opacity: 0; transition: opacity 0.3s ease;">
                                <li class="mt-3 mb-3 ms-4">
                                    <a href="{{route('roles.index')}}">
                                        <iconify-icon icon="solar:user-id-line-duotone"></iconify-icon>
                                        {{__("general.manage_roles")}}
                                    </a>
                                </li>
                                <li class="mt-3 mb-3 ms-4">
                                    <a href="{{route('permissions.index')}}">
                                        <iconify-icon icon="solar:lock-keyhole-minimalistic-line-duotone"></iconify-icon>
                                        {{__("general.manage_permissions")}}
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('productCurrencies.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi:currency-usd"></iconify-icon>
                                <span class="hide-menu">{{__("general.productCurrencies")}}</span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('products.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi:package-variant-closed"></iconify-icon>
                                <span class="hide-menu">{{__("general.products")}}</span>
                            </a>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('subProducts.index')}}" aria-expanded="false">
                                <iconify-icon icon="mdi:layers-outline"></iconify-icon>
                                <span class="hide-menu">{{__("general.subProducts")}}</span>
                            </a>
                        </li>


                        @php
                            $menus = $menus ?? collect();
                            $menus = $menus->sortBy(function($menu) {
                            return $menu->parent_id ? 999999 + $menu->id : $menu->id;
                        });
                        @endphp



                        @foreach($menus->where('parent_id', null) as $parent)
                            <li class="sidebar-item {{ $menus->where('parent_id', $parent->id)->count() ? 'has-submenu' : '' }}"
                                id="menu-item-{{ $parent->id }}">
                                <a class="sidebar-link" href="{{ $parent->link ?? 'javascript:void(0)' }}"
                                   aria-expanded="false"
                                   onclick="toggleSubMenu(event, 'submenu-{{ $parent->id }}')">
                                    <iconify-icon icon="{{ $parent->icon }}"></iconify-icon>
                                    <span class="hide-menu">{{ $parent->title }}</span>
                                    @if($menus->where('parent_id', $parent->id)->count())
                                        <iconify-icon id="icon-{{ $parent->id }}"
                                                      icon="solar:chevron-down-circle-line-duotone"
                                                      class="submenu-toggle-icon"></iconify-icon>
                                    @endif
                                </a>

                                @if($menus->where('parent_id', $parent->id)->count())
                                    <ul class="sidebar-submenu mt-3" id="submenu-{{ $parent->id }}"
                                        style="display: none; opacity: 0; transition: opacity 0.3s ease;">
                                        @foreach($menus->where('parent_id', $parent->id) as $child)
                                            <li class="mt-3 mb-3 ms-4">
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

        console.log("Toggling submenu:", submenuId);
        console.log("Icon element:", icon);

        if (submenu.style.display === "none" || submenu.style.opacity === "0") {
            submenu.style.display = "block";
            setTimeout(() => {
                submenu.style.opacity = "1";
            }, 10);

            if (icon) {
                icon.setAttribute("icon", "solar:chevron-up-circle-line-duotone");
                console.log("Icon changed to up");
            }
        } else {
            submenu.style.opacity = "0";
            setTimeout(() => {
                submenu.style.display = "none";
            }, 300);

            if (icon) {
                icon.setAttribute("icon", "solar:chevron-down-circle-line-duotone");
                console.log("Icon changed to down");
            }
        }
    }
</script>


