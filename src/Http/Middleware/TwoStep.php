<?php

namespace Namviet\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Namviet\Account\Http\Traits\TwoStepTrait;

class TwoStep
{
    use TwoStepTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        session()->put('twoStepUrl', $request->fullUrl());
        if ($this->twoStepVerification() !== true) {
            return redirect(route('system.users.two_steps.verification'));
        }
        return $next($request);
    }

}
