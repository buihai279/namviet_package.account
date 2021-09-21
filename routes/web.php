<?php

use Namviet\Account\Http\Controllers\AccountController;
use Namviet\Account\Http\Controllers\DashBoardsController;
use Namviet\Account\Http\Controllers\TwoStepController;
use Namviet\Account\Http\Controllers\UserGroupPermissionsController;
use Namviet\Account\Http\Controllers\UserGroupsController;
use Namviet\Account\Http\Controllers\UserGroupTypesController;
use Namviet\Account\Http\Controllers\UsersController;

Route::get('/', [DashBoardsController::class, 'index'])->name('index');
Route::post('user/login', [UsersController::class, 'login'])->name('system.user.login');
Route::prefix('system')->group(function () {
    Route::middleware(['permission'])->group(function () {
        Route::get('system/user/login', [DashBoardsController::class, 'index'])->name('login');
        Route::get('user_group/edit/{id}', [UserGroupsController::class, 'edit'])->name('system.user_group.edit');
        Route::post('user_group/edit/{id}', [UserGroupsController::class, 'edit'])->name('system.user_group.update');
        Route::post('user_group/add', [UserGroupsController::class, 'add'])->name('system.user_group.store');
        Route::get('user_group/add', [UserGroupsController::class, 'add'])->name('system.user_group.add');
        Route::get('user_group/index', [UserGroupsController::class, 'index'])->name('system.user_group.index');
        Route::post('user_group/toggle/{id}', [UserGroupsController::class, 'toggle'])->name('system.user_group.toggle');
        Route::get('user_group_permission/index', [UserGroupPermissionsController::class, 'index'])->name('system.user_group_permission.index');
        Route::post('user_group_permission/update/{id}', [UserGroupPermissionsController::class, 'edit'])->name('system.user_group_permission.edit');
        Route::get('user_group_type/edit/{id}', [UserGroupTypesController::class, 'edit'])->name('system.user_group_type.edit');
        Route::post('user_group_type/edit/{id}', [UserGroupTypesController::class, 'edit'])->name('system.user_group_type.update');
        Route::post('user_group_type/add', [UserGroupTypesController::class, 'add'])->name('system.user_group_type.store');
        Route::get('user_group_type/add', [UserGroupTypesController::class, 'add'])->name('system.user_group_type.add');
        Route::post('user_group_type/toggle/{id}', [UserGroupTypesController::class, 'toggle'])->name('system.user_group_type.toggle');
        Route::get('user_group_type/index', [UserGroupTypesController::class, 'index'])->name('system.user_group_type.index');
        Route::get('user/admin_edit/{id}', [UsersController::class, 'adminEdit'])->name('system.user.admin_edit');
        Route::post('user/admin_reset_password/{id}', [UsersController::class, 'adminResetPassword'])->name('system.user.admin_reset_password');
        Route::get('user/block/{id}', [UsersController::class, 'block'])->name('system.user.block');
        Route::post('user/block/{id}', [UsersController::class, 'block'])->name('system.user.block');
        Route::post('user/add', [UsersController::class, 'add'])->name('system.user.store');
        Route::get('user/add', [UsersController::class, 'add'])->name('system.user.add');
        Route::get('user/index', [UsersController::class, 'index'])->name('system.user.index');
        Route::get('user_group_permission/table', [UserGroupPermissionsController::class, 'table'])->name('system.user_group_permission.table');
    });
    Route::post('Account/updateProfile', [AccountController::class, 'updateProfile'])->name('system.user.updateProfile');
    Route::get('user/afterLogin', [UsersController::class, 'afterLogin'])->name('system.user.afterLogin');
    Route::get('refresh_captcha', [UsersController::class, 'refreshCaptcha'])->name('refresh.captcha');
    Route::get('account/settings', [AccountController::class, 'settings'])->name('account.settings');
    Route::post('account/update', [AccountController::class, 'update'])->name('account.update');
    Route::post('user/updateAdmin/{id}', [UsersController::class, 'adminEdit'])->name('system.user.updateAdmin');
    Route::get('user/notification', [UsersController::class, 'notification'])->name('system.user.notification');
    Route::post('user/notification/markAsReadAll', [UsersController::class, 'markAsReadAll'])->name('system.user.notification.markAsReadAll');
    Route::post('user/notification/destroyAll', [UsersController::class, 'destroyAll'])->name('system.user.notification.destroyAll');
    Route::get('user/notification/view/{id?}', [UsersController::class, 'detailNotification'])->name('system.user.notification.view');
    Route::get('user/logout', [UsersController::class, 'logout'])->name('system.user.logout');
    Route::get('user/twoSteps/verification/needed', [TwoStepController::class, 'twoStepsVerification'])->name('system.users.two_steps.verification');
    Route::post('user/twoSteps/verify', [TwoStepController::class, 'verify'])->name('system.users.two_steps.verify');
});
