<?php

namespace Namviet\Account;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Namviet\Account\Http\Middleware\Permission;
use Namviet\Account\Http\Middleware\TwoStep;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('permission', Permission::class);
        $router->aliasMiddleware('twoStep', TwoStep::class);
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'views');
        if ($this->app->runningInConsole()) {
            // Publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor'),
            ], 'nv-account-views');
            // Publish assets
        }
    }

    protected
    function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected
    function routeConfiguration()
    {
        return [
            'prefix' => config('namviet.prefix', 'approve'),
            'middleware' => config('namviet.middleware', ['web']),
        ];
    }
}
