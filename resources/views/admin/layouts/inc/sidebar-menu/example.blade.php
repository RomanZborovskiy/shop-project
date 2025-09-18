<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column js-activeable" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Сторінки<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Головна</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Продукти</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('posts.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Пости</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attributes.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Атрибути</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attributes.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Атрибути</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.categories.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Категорії</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Замовлення</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ролі</p>
                    </a>
                </li>
                
            </ul>
        </li>
        <li class="nav-item">
            <a href="/lte3/#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Example<span class="right badge badge-danger">Ex.</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/lte3/components" class="nav-link">
                <i class="nav-icon fas fa-cubes"></i>
                <p>Components<span class="right badge badge-success">22</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Layout Options<i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Top Navigation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Collapsed Sidebar</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">EXAMPLES</li>

        <li class="nav-item">
            <a href="/lte3/blank" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>Blank</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/lte3/login" class="nav-link">
                <i class="nav-icon fa fa-sign-in-alt"></i>
                <p>Login</p>
            </a>
        </li>

        <li class="nav-header">LABELS</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Important</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Warning</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-spinner fa-spin" style="color: red"></i>
                <p>Informational</p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
