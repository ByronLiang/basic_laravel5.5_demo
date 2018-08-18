<?php

namespace App\Models;

use App\Models\Traits\SafetyPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Socialite\SocialiteTrait;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, SafetyPassword, SoftDeletes;
    use \EloquentFilter\Filterable;
    use SocialiteTrait;
}
