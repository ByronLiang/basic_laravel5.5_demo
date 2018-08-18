<?php

namespace App\Models\Traits;

use DateTime;

trait ISO8601TimeFormat
{
    protected function serializeDate(DateTime $date)
    {
        return $date->setTimezone('UTC')->format('Y-m-d\TH:i:s').'.000Z';
    }
}
