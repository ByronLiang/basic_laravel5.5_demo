<?php

namespace App\Http\Controllers\Web\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyController extends Controller
{
    public function getProfile()
    {
        return \Response::success(auth()->user());
    }
}
