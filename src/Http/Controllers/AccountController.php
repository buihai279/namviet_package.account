<?php

namespace Namviet\Account\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Log;
use Namviet\Account\Http\Requests\AccountRequest;
use Namviet\Account\Http\Requests\AuthCodeRequest;
use Namviet\Account\Models\FileManaged;
use Namviet\Account\Models\User;
use Namviet\Account\Models\UserGroup;
use Namviet\Account\Repositories\UserRepository;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\TwoFactorAuthException;

class AccountController extends Controller
{

    private const SYS_ADMIN = 'SYS_ADMIN';
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function settings($id = '')
    {
        $tfa = new TwoFactorAuth('RobThree TwoFactorAuth');
        $secret = $tfa->createSecret();
        try {
            $qrImg = $tfa->getQRCodeImageAsDataUri('Demo', $secret);
            $tfa->getQRCodeImageAsDataUri('Demo', $secret);
        } catch (TwoFactorAuthException $exception) {
            Log::emergency($exception);
        }
        if (empty($id)) {
            return redirect(route('account.settings', Auth::id()));
        }
        $data = User::findOrFail($id);
        FileManaged::showFile($data);
        if (Auth::user()->code !== self::SYS_ADMIN) {
            $userGroups = UserGroup::select(['_id', 'name', 'status'])->whereIn('_id', UserGroup::getGroupPrivileged())->get();
        } else {
            //IF SYS ADMIN FULL PERMISSION
            $userGroups = UserGroup::select(['_id', 'name', 'status'])->get();
        }
        return view('views::account.settings', ['secret' => $secret, 'data' => $data, 'userGroups' => $userGroups, 'qrImg' => $qrImg]);
    }

    public function verifyAuthCode(AuthCodeRequest $request, $id)
    {
        $tfa = new TwoFactorAuth('RobThree TwoFactorAuth');
        try {
            $tfa->ensureCorrectTime();
            session()->flash('info', 'Your hosts time seems to be correct / within margin');
        } catch (TwoFactorAuthException $ex) {
            session()->flash('error', '<b>Warning:</b> Your hosts time seems to be off: ' . $ex->getMessage());
        }
        if ($tfa->verifyCode($request->get('authenticator_secret'), $request->get('authenticator_code'), 30) === true) {
            //nếu mã xác thực khớp với mã secret của app authentor thì lưu lại db
            $this->userRepository->update(['authenticator_secret' => $request->get('authenticator_secret')], $id);
        }
        return redirect(route('account.settings', $id));
    }

    public function update(AccountRequest $request, $id): RedirectResponse
    {
        $data = $request->all();
        FileManaged::processFile($data);//xu ly upload file
        $result = $this->userRepository->update($data, $id);
        Session::put('user', $result);//update profile thành công => update lại session
        $request->session()->flash('notice', __('notice.update_profile_success'));
        return redirect()->route('account.settings');
    }
}
