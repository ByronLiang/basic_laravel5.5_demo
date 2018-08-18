<?php

namespace App\ModelFilters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends ModelFilter
{
    public function _boot()
    {
        return $this->orderBy('id', 'desc');
    }

    public function keyword($val)
    {
        return $this->where(function (Builder $q) use ($val) {
            $q->orWhere('id', $val);
            $q->orWhere('username', 'like', '%'.$val.'%');
            $q->orWhere('account', 'like', '%'.$val.'%');
        });
    }

    public function rangeDate($val)
    {
        if (isset($val[1])) {
            $val[1] .= '23:59:59';
        }

        return $this->whereBetween('created_at', $val);
    }
}
