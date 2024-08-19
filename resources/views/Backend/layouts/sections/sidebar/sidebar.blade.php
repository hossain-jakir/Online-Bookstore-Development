<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('backend.dashboard') }}" class="brand-link" style="height: 60px; display: flex; align-items: center; justify-content: center;">
        <img src="{{ Storage::url($shop->logo) }}" alt="{{ $shop->name }}" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('backend.site.short_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="height: calc(100vh - 60px); overflow-y: auto; padding-bottom: 10px;">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ \Facades\App\Services\ServeImage::profile(Auth::user(),'thumbanil') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('backend.dashboard') }}" class="nav-link @if (Route::currentRouteName() == 'backend.dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Category -->
                @canAny('view category', 'create category', 'edit category', 'delete category')
                <li class="nav-item {{ Route::is('backend.category.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('backend.category.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Category<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('view category')
                        <li class="nav-item">
                            <a href="{{ route('backend.category.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.category.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        @endcan
                        @can('create category')
                        <li class="nav-item">
                            <a href="{{ route('backend.category.create') }}" class="nav-link @if (Route::currentRouteName() == 'backend.category.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanAny

                <!-- Book -->
                @canAny('create book', 'edit book', 'delete book', 'view book')
                <li class="nav-item {{ Route::is('backend.book.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('backend.book.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Book<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('view book')
                        <li class="nav-item">
                            <a href="{{ route('backend.book.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.book.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        @endcan
                        @can('create book')
                        <li class="nav-item">
                            <a href="{{ route('backend.book.create') }}" class="nav-link @if (Route::currentRouteName() == 'backend.book.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanAny

                <!-- Order -->
                <li class="nav-item {{ Route::is('backend.order.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('backend.order.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Order<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.order.index') }}" class="nav-link {{ Route::is('backend.order.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Transaction -->
                <li class="nav-item">
                    <a href="{{ route('backend.transaction.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.transaction.index') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Transaction</p>
                    </a>
                </li>

                <!-- User Management -->
                @canAny('create user', 'edit user', 'delete user', 'view user', 'role assign')
                <li class="nav-item">
                    <a href="{{ route('backend.user.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.user.index') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                @endcanAny

                <!-- Role Permission -->
                @canAny('create role', 'edit role', 'delete role', 'view role')
                <li class="nav-item">
                    <a href="{{ route('backend.role.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.role.index') active @endif">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Role Permission</p>
                    </a>
                </li>
                @endcanAny

                <!-- Shop -->
                <li class="nav-item">
                    <a href="{{ route('backend.shop.index') }}" class="nav-link @if (Route::currentRouteName() == 'backend.shop.index') active @endif">
                        <i class="nav-icon fas fa-store"></i>
                        <p>Shop</p>
                    </a>
                </li>

                <!-- Reports -->
                <li class="nav-item {{ Route::is('backend.report.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('backend.report.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Report<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.report.salesReport',['year' => date('Y'), 'month' => date('m')]) }}" class="nav-link @if (Route::currentRouteName() == 'backend.report.salesReport') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.report.dailySales', ['year' => date('Y'), 'month' => date('m')]) }}" class="nav-link @if (Route::currentRouteName() == 'backend.report.dailySales') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daily Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.report.monthlySales', ['year' => date('Y')]) }}" class="nav-link @if (Route::currentRouteName() == 'backend.report.monthlySales') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Monthly Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.report.bestSeller') }}" class="nav-link @if (Route::currentRouteName() == 'backend.report.bestSeller') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Best Seller Books</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.report.bestSellingAuthors') }}" class="nav-link @if (Route::currentRouteName() == 'backend.report.bestSellingAuthors') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Best Selling Authors</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
