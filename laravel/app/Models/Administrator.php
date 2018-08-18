<?php

namespace App\Models;

use App\Models\Traits\SafetyPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Administrator extends Model implements AuthenticatableContract
{
    use Authenticatable, SafetyPassword;
}
