<?php

namespace Modules\Socialite\Tests;

use Modules\Socialite\Entities\Socialite;
use Tests\TestCase;

class SocialiteTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testExample()
    {
        Socialite::whereWechatId('2342', '234324')->get();

        $this->assertTrue(true);
    }
}
