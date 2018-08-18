<?php

namespace App\Http\Controllers\Web;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function postLogin()
    {
        if (auth()->attempt([
            'phone' => request('phone'),
            'password' => request('password'),
        ], false)) {
            return \Response::success(auth()->user());
        }

        return \Response::error('账号或者密码错误');
    }

    public function postRegister()
    {
        $model = User::create([
            'phone' => request('phone'),
            'password' => request('password'),
            'avatar' => 'https://picsum.photos/80/80?120',
            'name' => 'Lily',
        ]);
        if ($model) {
            Auth::login($model);
        }

        return \Response::success($model);
    }
}
