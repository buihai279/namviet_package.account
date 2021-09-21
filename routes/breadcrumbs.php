<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.

//Note định nghĩa tên route == tên breadcrumbs để ngoài view lấy tự động ở component layouts.partials.breadcrumb
// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('label.dashboard.title'), route('index'));
});
// Home > account > settings
Breadcrumbs::for('account.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('label.account.title_setting'), route('account.settings'));
});


Breadcrumbs::after(function (BreadcrumbTrail $trail) {
    $page = (int)request('page', 1);
    if ($page > 1) {
        $trail->push(__('label.page', ['page' => $page]));
    }
});
