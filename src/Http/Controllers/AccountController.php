<?php

namespace Namviet\Account\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Namviet\Account\Models\FileManaged;
use Namviet\Account\Models\User;

class AccountController extends Controller
{

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function settings()
    {
        $data = User::find(Auth::id());
        FileManaged::showFile($data);
        return view('views::account.settings', ['data' => $data]);
    }


    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'fullname' => 'max:25|min:1',
            'email' => 'unique:users',
            'mobile' => 'digits:10',
            'password' => 'max:255|min:6|confirmed|different:password_old',
        ]);

        $data = $request->toArray();
        FileManaged::processFile($data);//xu ly upload file
        $result = $this->userRepository->update($data, Auth::id());
        Session::put('user', $result);//update profile thành công => update lại session
        $request->session()->flash('notice', __('notice.update_profile_success'));
        return redirect()->route('system.user.edit');
    }
}
