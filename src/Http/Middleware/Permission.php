<?php

namespace Namviet\Account\Http\Middleware;

use Auth;
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
    public function handle(Request $request, Closure $next)
    {
        $permissionField = config('namviet_account.permission_field');
        if (Auth::user()->code === 'SYS_ADMIN') {//sys_admin has full permisson
            return $next($request);
        }
        $routeArray = $request->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);//ex: PostsController@write
        $controllerName = str_replace('Controller@', '/', $controllerAction);
        $permissions = Auth::user()->userGroup->{$permissionField};
        if (Auth::guest() || !in_array($controllerName, $permissions, true)) {
            $request->session()->flash('notice', 'Không có quyền truy cập!');
            return back()->withInput();
        }
        return $next($request);
    }
}
