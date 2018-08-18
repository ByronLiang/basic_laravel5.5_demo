<?php

namespace Ganguo\ModelExpansion;

/**
 * @mixin \Eloquent
 */
trait LoadCountTrait
{
    /**
     * @param $relations
     *
     * @return $this
     */
    public function loadCount($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        foreach ($relations as $relation) {
            $this->setAttribute($relation.'_count', $this->{$relation}()->count());
        }

        return $this;
    }
}
