<?php

namespace Modules\Socialite\Entities;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * @method static |self whereWechatId(string $open_id, string $union_id = null)
 */
class Socialite extends \App\Models\Model
{
    protected $casts = [
        'extend' => 'object',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            if (!in_array($model->provider, array_keys(trans('Socialite::Socialite.provider')))) {
                return abort(500, '未定义登录类型语言: '.$model->provider);
            }
        });
    }

    public function getProviderTransAttribute()
    {
        return trans('Socialite::socialite.provider.'.$this->provider);
    }

    public function able()
    {
        return $this->morphTo();
    }

    public static function whereUniqueId($value)
    {
        return static::where('unique_id', $value);
    }

    /**
     * WhereWechatId.
     *
     * @param EloquentBuilder $builder
     * @param $open_id
     * @param $union_id
     *
     * @return EloquentBuilder
     */
    public function scopeWhereWechatId(EloquentBuilder $builder, string $open_id, string $union_id = null)
    {
        return $builder
            ->where('provider', 'like', 'wechat_%')
            ->where(function (EloquentBuilder $builder) use ($open_id, $union_id) {
                $builder->orWhere('', $open_id);
                if ($union_id) {
                    $builder->orWhere('extend', 'like', '%'.$union_id.'%');
                }
            });
    }
}
