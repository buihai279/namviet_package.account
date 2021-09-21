<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashBoardsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->time_expired->isFuture() && Auth::user()->time_expired->diffInDays(now()) <= 3) {
                $rangeTimeStr = gmdate('d \n\g\à\y H:i:s \g\i\â\y', Auth::user()->time_expired->diffInSeconds(now()));
                session()->flash('error', __('notice.time_remaining', ['timeStr' => $rangeTimeStr]));
                return redirect(route('system.user.edit'));
            }
            if (Auth::user()->time_expired->isPast()) {
                session()->flash('error', __('notice.password_expired'));
                return redirect(route('system.user.edit'));
            }
            if (empty(Auth::user()->mobile)) {
                session()->flash('error', __('notice.add_mobile'));
                return redirect(route('system.user.edit'));
            }
            return view('views::dashboards.index');
        }
        return view('views::account.login');
    }

}
