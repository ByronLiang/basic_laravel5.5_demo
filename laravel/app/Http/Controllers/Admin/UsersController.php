<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\RESTfulTrait;
use App\Models\User;

class UsersController extends Controller
{
    use RESTfulTrait;

    protected $model = User::class;
}
