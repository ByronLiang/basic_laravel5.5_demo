<?php

namespace App\ModelFilters;

/**
 * @mixin \App\Models\Model
 */
abstract class ModelFilter extends \EloquentFilter\ModelFilter
{
    public function __construct($query, array $input = [], bool $relationsEnabled = true)
    {
        parent::__construct($query, $input, $relationsEnabled);
        if (method_exists($this, '_boot')) {
            $this->_boot();
        }
    }

    public function id($val)
    {
        $this->where(__FUNCTION__, (int) $val);
    }

    public function ids($val)
    {
        $val = (array) $val;
        $this->whereIn('id', $val);
        $this->orderByRaw('FIND_IN_SET(`id`, \''.implode(',', $val).'\')');
    }

    protected function stringToArray($val, $delimiter = ',')
    {
        if (is_array($val)) {
            return $val;
        }

        return explode($delimiter, $val);
    }

    public function with($relations)
    {
        parent::with(is_string($relations) ? func_get_args() : $relations);
    }

    public function withCount($relations)
    {
        parent::withCount(is_string($relations) ? func_get_args() : $relations);
    }

    public function sortOrder($val)
    {
        foreach ((array) $val as $k => $v) {
            $this->orderBy($k, $v);
        }
    }

    public function has($relation)
    {
        parent::has($relation);
    }

    public function doesntHave($relation)
    {
        parent::doesntHave($relation);
    }
}
