<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function postLogin(LoginRequest $request)
    {
        if (auth()->attempt($request->extractInputFromRules(), $request->remember)) {
            return \Response::success(auth()->user());
        }

        return \Response::error('账号或者密码错误');
    }
}
