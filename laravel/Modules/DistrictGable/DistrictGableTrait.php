<?php

namespace Modules\DistrictGable;

use Modules\DistrictGable\Entities\District;

/**
 * Trait Taggable.
 *
 * @method static static WithAnyTag($tagNames)
 * @method static static WithoutTags($tagNames)
 * @mixin \Eloquent
 */
trait DistrictGableTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany|District
     */
    public function districts()
    {
        return $this->morphToMany(District::class, 'gable', 'district_gables');
    }

    /**
     * districts_names.
     *
     * @return string
     */
    public function getDistrictNamesAttribute()
    {
        $districts = $this->relationLoaded('districts') ? $this->districts : $this->districts();

        return $districts->pluck('full_name')->implode(',');
    }

    /**
     * districts_id.
     *
     * @return string
     */
    public function getDistrictsIdAttribute()
    {
        $districts = $this->relationLoaded('districts') ? $this->districts : $this->districts();

        return $districts->pluck('id');
    }
}
