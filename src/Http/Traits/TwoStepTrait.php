<?php

namespace Namviet\Account\Http\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait TwoStepTrait
{

    /**
     * Check if the user is authorized.
     *
     *
     * @return bool
     */
    public function twoStepVerification(): bool
    {
        $user = Auth::User();

        if ($user) {

            if ($this->checkTimeSinceVerified()) {
                return false;
            }

            return true;
        }

        return true;
    }


    /**
     * Check time since user was last verified and take apprpriate action.
     *
     * @return bool
     */
    private function checkTimeSinceVerified(): bool
    {
        if (empty(session('last_two_step'))) {
            return true;
        }
        $expireMinutes = 5;
        $now = Carbon::now();
        $expire = Carbon::parse(session('last_two_step'))->addMinutes($expireMinutes);
        $expired = $now->gt($expire);
        if ($expired) {
            return true;
        }

        return false;
    }


    /**
     * Gửi OTP.
     *
     */
    protected function sentOtp()
    {
        $body = ['mobile' => Auth::user()->mobile];
        $response = $this->api->post(self::URI_SEND_OTP, $body);
        Log::info(json_encode($response));
        return !empty($response) && !empty($response->data) ? $response->data : null;
    }

    /**
     * Xác nhận OTP.
     *
     * @param $otp
     * @return false
     */
    protected function validateOtp($otp): bool
    {
        $body = [
            'mobile' => Auth::user()->mobile,
            'otp' => $otp
        ];
        $response = $this->api->post(self::URI_CONFIRM_OTP, $body);
        Log::info(json_encode($response));
        return !empty($response) && !empty($response->data) ? $response->data : FALSE;
    }


}
