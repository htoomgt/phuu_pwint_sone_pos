<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('images/admin-lte/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Phuu Pwint Sone POS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('images/admin-lte/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{Auth::user()->full_name}}</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                {{-- Dashboard  --}}
                <li class="nav-item">
                    <a href="{{route('home.dashboard')}}" class="nav-link @if($pageTitle=='Dashboard') active  @endif ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- /Dashboard  --}}
                {{-- Manage Product --}}
                <li class="nav-item @if($pageTitle=='Manage Product') menu-open  @endif">
                    <a href="#" class="nav-link @if($pageTitle=='Manage Product') active  @endif">
                        <i class="nav-icon fas fa-gifts"></i>
                        <p>
                            Manage Product
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('product.showList')}}" class="nav-link @if($lvl2PageTitle=='Product List') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('product.create')}}" class="nav-link @if($lvl2PageTitle=='Product Create') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setup a product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('productPurchase.showList')}}" class="nav-link @if($lvl2PageTitle=='Product Purchase List') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Product List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('productPurchase.create')}}" class="nav-link @if($lvl2PageTitle=='Product Purchase Create') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('productCategory.showList')}}" class="nav-link @if($lvl2PageTitle=='Product Category') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('productMeasureUnit.showList')}}" class="nav-link @if($lvl2PageTitle=='Product Measure Unit') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Measure Unit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{route('productBreakdown.showList')}}"
                                class="nav-link
                                @if($lvl2PageTitle=='Product Breakdown') active  @endif
                                @if($lvl2PageTitle=='Edit Product Breakdown') active  @endif
                                @if($lvl2PageTitle=='Make Product Breakdown') active  @endif"

                                >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Breakdown</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- /Manage Product --}}

                {{-- Sale  --}}
                <li class="nav-item ">
                    <a href="{{route('sale.main')}}" class="nav-link @if($pageTitle=='Point of Sale') active  @endif">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Point of Sale
                        </p>
                    </a>
                </li>
                {{-- /Sale  --}}

                {{-- Reports  --}}
                <li class="nav-item @if($pageTitle=='Report') menu-open  @endif">
                    <a href="#" class="nav-link @if($pageTitle=='Report') active  @endif">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('report.saleAndProfitDaily')}}" class="nav-link @if($lvl2PageTitle=='Sale And Profit Daily') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sale and profit daily</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.saleAndProfit')}}" class="nav-link @if($lvl2PageTitle=='Sale And Profit') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sale and profit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.inventory')}}" class="nav-link @if($lvl2PageTitle=='Inventory') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.inventory_daily')}}" class="nav-link @if($lvl2PageTitle=='Daily Inventory') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daily Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reorder Level List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- /Reports  --}}
                {{-- Manage User --}}
                <li class="nav-item @if($pageTitle=='Manage User') menu-open  @endif">
                    <a href="#" class="nav-link @if($pageTitle=='Manage User') active  @endif ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Manage User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.showList')}}" class="nav-link @if($lvl2PageTitle=='User List') active  @endif ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.create')}}" class="nav-link @if($lvl2PageTitle=='Create User') active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- /Manage User --}}
                {{-- System Settings --}}
                <li class="nav-item">
                    <a href="{{route('system_settings.showList')}}" class="nav-link @if($pageTitle=='System Settings') active  @endif">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            System Settings

                        </p>
                    </a>
                </li>

                {{-- /System Settings --}}




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
