    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    <!-- Topbar Start -->
    <div class="container-fluid px-5 d-none border-bottom d-lg-block">
    <div class="row gx-0 align-items-center" style="height: 45px;">
        
        <div class="col-lg-4">
            @if (Breadcrumbs::exists(Route::currentRouteName()))
                <div aria-label="breadcrumb">
                    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? $product ?? $order ?? $page ?? null) }}
                </div>
            @endif
        </div>

        <div class="col-lg-4 text-center">
            <div class="d-inline-flex align-items-center">
                <small class="text-dark me-2">Телефонуйте нам:</small>
                <a href="tel:+0121234567890" class="text-muted">(+012) 1234 567890</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-end">
                
                <form action="{{ route('client.currency.change') }}" method="POST" class="d-inline me-2">
                    @csrf
                    <select name="currency" onchange="this.form.submit()" class="form-select form-select-sm border-0">
                        @foreach(config('currency.available') as $curr)
                            <option value="{{ $curr }}" {{ currency_active() === $curr ? 'selected' : '' }}>
                                {{ $curr }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="dropdown me-2">
                    <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown"><small>Українська</small></a>
                    <div class="dropdown-menu rounded">
                        <a href="#" class="dropdown-item">Українська</a>
                        <a href="#" class="dropdown-item">English</a>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown">
                        <small>
                            <i class="fa fa-user me-2"></i>
                            @auth
                                {{ Auth::user()->name }}
                            @else
                                Гість
                            @endauth
                        </small>
                    </a>
                    <div class="dropdown-menu rounded dropdown-menu-end">
                        @guest
                            <a href="{{ route('login') }}" class="dropdown-item">Вхід</a>
                            <a href="{{ route('register') }}" class="dropdown-item">Реєстрація</a>
                        @else
                            <a href="{{ route('client.profile.orders.index') }}" class="dropdown-item">Мої замовлення</a>
                            <a href="{{ route('client.profile.show') }}" class="dropdown-item">Мій профіль</a>
                            <a href="{{ route('client.favorites.products') }}" class="dropdown-item">Обрані</a>
                            @role('admin')
                                <hr class="dropdown-divider">
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Адмін-панель</a>
                            @endrole
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Вийти</button>
                            </form>
                        @endguest
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    <div class="container-fluid px-5 py-4 d-none d-lg-block">
    <div class="row gx-0 align-items-center text-center">
        <div class="col-md-4 col-lg-3 text-center text-lg-start">
            <div class="d-inline-flex align-items-center">
                <a href="/" class="navbar-brand p-0">
                    <h1 class="display-5 text-primary m-0">
                        <i class="fas fa-shopping-bag text-secondary me-2"></i>Shop
                    </h1>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-lg-6">
            <form action="{{ route('client.shop.search') }}" method="GET" class="d-flex mx-auto" style="max-width: 500px;">
                <input type="text"
                       name="name"
                       value="{{ request('name') }}"
                       class="form-control me-2"
                       placeholder="Пошук товарів...">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="col-md-4 col-lg-3 text-center text-lg-end">
            <div class="d-inline-flex align-items-center">
                <a href="#" class="text-muted d-flex align-items-center justify-content-center me-3">
                    <span class="rounded-circle btn-md-square border">
                        <i class="fas fa-random"></i>
                    </span>
                </a>
                <a href="#" class="text-muted d-flex align-items-center justify-content-center me-3">
                    <span class="rounded-circle btn-md-square border">
                        <i class="fas fa-heart"></i>
                    </span>
                </a>
                <a href="#" class="text-muted d-flex align-items-center justify-content-center">
                    <span class="rounded-circle btn-md-square border">
                        <i class="fas fa-shopping-cart"></i>
                    </span>
                    <span class="text-dark ms-2">$0.00</span>
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid nav-bar p-0">
        <div class="row gx-0 bg-primary px-5 align-items-center">
            <div class="col-lg-3 d-none d-lg-block">
                <nav class="navbar navbar-light position-relative" style="width: 250px;">
                    <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button"
                        data-bs-toggle="collapse" data-bs-target="#allCat">
                        <h4 class="m-0"><i class="fa fa-bars me-2"></i>All Categories</h4>
                    </button>
                    <div class="collapse navbar-collapse rounded-bottom" id="allCat">
                        <div class="navbar-nav ms-auto py-0">
                            <ul class="list-unstyled categories-bars">
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="#">Accessories</a>
                                        <span>(3)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="#">Electronics & Computer</a>
                                        <span>(5)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="#">Laptops & Desktops</a>
                                        <span>(2)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="#">Mobiles & Tablets</a>
                                        <span>(8)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="#">SmartPhone & Smart TV</a>
                                        <span>(5)</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-9">
                <nav class="navbar navbar-expand-lg navbar-light bg-primary ">
                    <a href="" class="navbar-brand d-block d-lg-none">
                        <h1 class="display-5 text-secondary m-0"><i
                                class="fas fa-shopping-bag text-white me-2"></i>Electro</h1>
                        <!-- <img src="img/logo.png" alt="Logo"> -->
                    </a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars fa-1x"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0">
                            <a href="{{route('client.dashboard')}}" class="nav-item nav-link active">Головна</a>
                            <a href="{{route('client.catalog.index')}}" class="nav-item nav-link">Каталог</a>
                            <a href="{{route('client.shop.index')}}" class="nav-item nav-link">Магазин</a>
                            <a href="single.html" class="nav-item nav-link">Single Page</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Сторінки</a>
                                <div class="dropdown-menu m-0">
                                    <a href={{route('client.page.show', 'about')}} class="dropdown-item">Про нас</a>
                                    <a href={{route('client.page.show', 'delivery')}} class="dropdown-item">Доставка</a>
                                    <a href={{route('client.page.show', 'policy')}} class="dropdown-item">Політика конфіденційності</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link me-2">Contact</a>
                            <div class="nav-item dropdown d-block d-lg-none mb-3">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">All Category</a>
                                <div class="dropdown-menu m-0">
                                    <ul class="list-unstyled categories-bars">
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="#">Accessories</a>
                                                <span>(3)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="#">Electronics & Computer</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="#">Laptops & Desktops</a>
                                                <span>(2)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="#">Mobiles & Tablets</a>
                                                <span>(8)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="#">SmartPhone & Smart TV</a>
                                                <span>(5)</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a href="" class="btn btn-secondary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0"><i
                                class="fa fa-mobile-alt me-2"></i> +0123 456 7890</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
