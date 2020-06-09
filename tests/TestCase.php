<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function fakeUsers()
    {
    	return factory(\App\User::class, 100)->create();
    }
}
