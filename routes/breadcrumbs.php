<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

//головна
Breadcrumbs::for('client.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Головна', route('client.dashboard'));
});

//профіль
Breadcrumbs::for('client.profile.show', function (BreadcrumbTrail $trail) {
    $trail->parent('client.dashboard');
    $trail->push('Профіль', route('client.profile.show'));
});

Breadcrumbs::for('client.profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('client.profile.show');
    $trail->push('Редагування', route('client.profile.edit'));
});

Breadcrumbs::for('client.profile.orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('client.profile.show');
    $trail->push('Мої замовлення', route('client.profile.orders.index'));
});

Breadcrumbs::for('client.profile.orders.show', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('client.profile.orders.index');
    $trail->push("Замовлення #{$order->id}", route('client.profile.orders.show', $order));
});

//пости
Breadcrumbs::for('client.posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('client.dashboard');
    $trail->push('Блог', route('client.posts.index'));
});

// Breadcrumbs::for('client.posts.show', function (BreadcrumbTrail $trail, $post) {
//     $trail->parent('client.posts.index');
//     $trail->push($post->name, route('client.posts.show', $post));
// });

//каталог
Breadcrumbs::for('client.catalog.index', function (BreadcrumbTrail $trail) {
    $trail->parent('client.dashboard');
    $trail->push('Каталог', route('client.catalog.index'));
});

// Breadcrumbs::for('client.catalog.show', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('client.catalog.index');
//     $trail->push($category->name, route('client.catalog.show', $category));
// });

//магазин
Breadcrumbs::for('client.shop.index', function (BreadcrumbTrail $trail) {
    $trail->parent('client.dashboard');
    $trail->push('Магазин', route('client.shop.index'));
});

Breadcrumbs::for('client.shop.show', function (BreadcrumbTrail $trail, $product) {
    if ($product->category) {
        $trail->parent('client.catalog.show', $product->category);
    } else {
        $trail->parent('client.shop.index'); 
    }

    $trail->push($product->name, route('client.shop.show', $product));
});

//пошук
Breadcrumbs::for('client.shop.search', function (BreadcrumbTrail $trail) {
    $trail->parent('client.shop.index');
    $trail->push('Пошук', route('client.shop.search'));
});


Breadcrumbs::for('client.page.show', function (BreadcrumbTrail $trail, $page) {
    $trail->parent('client.dashboard');
    $trail->push($page->name, route('client.page.show', $page->template));
});