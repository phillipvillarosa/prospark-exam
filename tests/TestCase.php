<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function fakeUsers()
    {
    	return factory(\App\User::class, 100)->create();
    }

    function createUsersAndSelect()
    {
    	$users = $this->fakeUsers();

    	return $users->random();
    }
}
