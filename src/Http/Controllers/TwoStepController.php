<?php

namespace Namviet\Account\Http\Controllers;

use App\Services\ExternalApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Namviet\Account\Http\Traits\TwoStepTrait;

class TwoStepController extends Controller
{
    private const URI_SEND_OTP = 'user/otp/send';
    private const URI_CONFIRM_OTP = 'user/otp/confirm';

    use TwoStepTrait;

    private $api = null;

    public function __construct(ExternalApi $api)
    {
        $this->api = $api;
    }

    public function twoStepsVerification()
    {
        $this->sentOtp();
        return view('views::users.two-steps');
    }

    /**
     * Verify the user code input.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'v_input_1' => 'required|min:1|max:1',
            'v_input_2' => 'required|min:1|max:1',
            'v_input_3' => 'required|min:1|max:1',
            'v_input_4' => 'required|min:1|max:1',
            'v_input_5' => 'required|min:1|max:1',
            'v_input_6' => 'required|min:1|max:1',
        ]);

        if ($validator->fails()) {
            return response()->json('OTP not valid', 401);
        }

        $code = $request->v_input_1 . $request->v_input_2 . $request->v_input_3 . $request->v_input_4 . $request->v_input_5 . $request->v_input_6;

        $validateOtp = $this->validateOtp($code);
        if ($validateOtp !== true) {
            return response()->json('OTP not match', 401);
        }
        session()->put('last_two_step', now());
        $twoStepUrl = session('twoStepUrl');
        session()->put('twoStepUrl', '');
        return response()->json(['message' => 'success', 'nextUrl' => $twoStepUrl]);
    }

}
