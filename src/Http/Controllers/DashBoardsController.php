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
                return redirect(route('account.settings', Auth::id()))->with('error', __('notice.time_remaining', ['timeStr' => $rangeTimeStr]));
            }
            if (Auth::user()->time_expired->isPast()) {
                return redirect(route('account.settings', Auth::id()))->with('error', __('notice.password_expired'));
            }
            if (empty(Auth::user()->mobile)) {
                return redirect(route('account.settings', Auth::id()))->with('error', __('notice.add_mobile_to_2fa'));
            }
            return view('views::dashboards.index');
        }

        if (!empty(config('app.project_name')) && config('app.project_name') == 'VTP')
        {
            return redirect(route('vue.user.login'));
        }

        return view('views::account.login');
    }

}
