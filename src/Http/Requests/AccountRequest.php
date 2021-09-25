<?php

namespace Namviet\Account\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => 'max:25|min:1',
            'email' => 'unique:users',
            'mobile' => 'digits:11|starts_with:84',
            'password' => 'max:255|min:6|confirmed|different:password_old',
        ];
    }
}
