<?php

namespace App\Models;

// use App\Models\Traits\ISO8601TimeFormat;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    use \Ganguo\ModelExpansion\BelongsToOneTrait;
    use \Ganguo\ModelExpansion\HasInTrait;
    // use ISO8601TimeFormat;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];
}
