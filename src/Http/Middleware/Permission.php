<?php

namespace Namviet\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeArray = $request->route()->getAction();

        $controllerAction = class_basename($routeArray['controller']);//ex: PostsController@write
        $controllerName = str_replace('Controller@', '/', $controllerAction);

        $permissions = session()->get('userGroup')['permissions'] ?? [];

        if (empty($permissions) || !in_array($controllerName, $permissions, true)) {
            $request->session()->flash('notice', 'Không có quyền truy cập!');
            return back()->withInput();
        }
        return $next($request);
    }
}
