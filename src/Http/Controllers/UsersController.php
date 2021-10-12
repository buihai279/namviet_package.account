<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Namviet\Account\Http\Requests\LoginRequest;
use Namviet\Account\Http\Resources\UserResource;
use Namviet\Account\Models\Notification;
use Namviet\Account\Models\User;
use Namviet\Account\Models\UserGroup;
use Namviet\Account\Models\UserGroupType;
use Namviet\Account\Repositories\UserRepository;

class UsersController extends Controller
{
    private const SYS_ADMIN = 'SYS_ADMIN';
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
//        $this->middleware('twoStep')->only('afterLogin');
    }

    public function apiAll()
    {
        return UserResource::collection(User::all());
    }

    public function login(LoginRequest $request)
    {
        //validate captcha
        if (Session::get('check') >= 3) {
            $request->validate([
                'captcha' => 'required|captcha',
            ]);
        }
        $credentials = $request->only('username', 'password');
        $credentials['status'] = User::ACTIVE_STATUS;

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            Session::forget('check');
            if (empty(Auth::user()->time_expired)) {
                //set time_expired if not isset
                Auth::user()->time_expired = strtotime('+ 3 months');
                Auth::user()->save();
            }
            return redirect(route('system.user.afterLogin'));
        }
        Session::increment('check');

        //  not valid
        Session::put('user', []);
        Session::put('userGroups', []);
        Session::put('userGroupType', []);
        Session::save();
        $request->session()->flash('error', __('notice.user_pass_wrong'));
        return redirect(route('index'));
    }

    public function index()
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $users = User::whereIn('user_group', UserGroup::getGroupPrivileged())->get();
        } else {
            $users = User::all();
        }
        return view('views::users.index', [
            'users' => $users,
            'userNameList' => User::getListHtml(),
            'userGroups' => UserGroup::getList()
        ]);
    }


    public function block(Request $request, $id)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $data = User::whereIn('user_group', UserGroup::getGroupPrivileged())->findOrFail($id);
        } else {
            //IF SYS ADMIN FULL PERMISSION
            $data = User::findOrFail($id);
        }
        if ($request->getMethod() === 'POST') {
            $request->validate([
                'status' => 'required',
                'reason_block' => 'required',
            ]);
            $requestAll = $request->only(['status', 'reason_block']);
            $update = User::where('_id', $id)->update(['status' => (int)$requestAll['status'], 'reason_block' => $requestAll['reason_block']]);
            $request->session()->flash('notice', $update ? __('notice.operation_success') : __('notice.error_occurred'));
            return redirect(route('system.user.index'));
        }
        return view('views::users.block', ['user' => $data]);
    }

    public function notification()
    {
        return view('views::users.notification', ['notifications' => Auth::user()->notifications()->paginate(10)]);
    }

    public function detailNotification($id)
    {
        Auth::user()->unreadNotifications->where('_id', $id)->markAsRead();
        return redirect(Notification::getRedirectUrl($id));
    }

    public function add(Request $request)
    {
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroups = UserGroup::select(['_id', 'name', 'status'])->whereIn('_id', UserGroup::getGroupPrivileged())->get();
        } else {
            //IF SYS ADMIN FULL PERMISSION
            $userGroups = UserGroup::select(['_id', 'name', 'status'])->get();
        }
        if ($request->getMethod() === 'POST') {
            return $this->store($request);
        }
        return view('views::users.add', ['userGroups' => $userGroups]);
    }

    private function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|regex:/^[a-z._0-9]+$/|unique:users',
            'email' => 'required|unique:users',
            'mobile' => 'required|digits:11',
            'description' => 'required',
            'status' => 'required',
            'user_group' => 'required',
            'otp_active' => 'required',
            'password' => 'required|max:255|min:6|confirmed|different:password_old',
            'password_confirmation' => 'required',
        ]);
        $result = $this->userRepository->create($request->all());
        if ($result) {
            $request->session()->flash('notice', __('notice.create_success'));
        } else {
            $request->session()->flash('notice', __('notice.error_occurred'));
        }
        return redirect()->route('system.user.index');
    }

    public function markAsReadAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect(route('system.user.notification'));
    }

    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        return redirect(route('system.user.notification'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect(route('index'));
    }


    public function refreshCaptcha(): string
    {
        return captcha_img('math');
    }

    public function afterLogin()
    {
        if (!Auth::user()) {
            return redirect(route('index'))->with('notice', __('notice.error_occurred'));
        }
        Session::put('user', Auth::user());
        $userGroup = Auth::user()->userGroup;

        if (isset($userGroup->status) && $userGroup->status === UserGroup::INACTIVE_STATUS) {
            Auth::logout();
            return redirect(route('index'))->with('notice', __('notice.login_fail_user_group_block'));
        }
        $userGroupType = UserGroupType::find((string)$userGroup->user_group_type);
        if (isset($userGroupType->status) && $userGroupType->status === UserGroupType::INACTIVE_STATUS) {
            Auth::logout();
            return redirect(route('index'))->with('notice', ('notice.login_fail_department_block'));
        }
        Session::put('userGroup', $userGroup);
        Session::put('userGroupType', $userGroupType);
        Session::save();
        return redirect(route('index'));
    }
}
