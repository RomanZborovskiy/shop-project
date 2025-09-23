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
                    <a href="{{route('products.index')}}" class="nav-link" data-pat="products" >
                        <i class="far fa-circle nav-icon"></i>
                        <p>Продукти</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('posts.index')}}" class="nav-link" data-pat="posts">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Пости</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attributes.index')}}" class="nav-link" data-pat="attributes">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Атрибути</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.categories.index')}}" class="nav-link" data-pat="admin.categories">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Категорії</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link" data-pat="orders">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Замовлення</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link" data-pat="users">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Користувачі</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('leads.index')}}" class="nav-link" data-pat="leads">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ліди</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link" data-pat="roles">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ролі</p>
                    </a>
                </li> --}}
                
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
