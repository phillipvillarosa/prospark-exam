<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowAllUsers()
    {
        $users = $this->fakeUsers();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJson([
                'users' => [
                    'total' => $users->count(),
                ]
            ]);
    }

    public function testShowAUser()
    {
        $users = $this->fakeUsers();

        $selected_user = $users->random();

        $response = $this->getJson('api/users/' . $selected_user->id);

        $response->assertStatus(200)
            ->assertJson([
                'user' => $selected_user->toArray()
            ]);
    }

    public function testUpdateAUser()
    {
        $users = $this->fakeUsers();

        $selected_user = $users->random();

        $updated_user = $this->patchJson('api/users/' . $selected_user->id, [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com'
        ]);
    }

    public function testDeleteAUser()
    {
        $users = $this->fakeUsers();

        $selected_user = $users->random();

        $delete_user = $this->deleteJson('api/users/' . $selected_user->id);

        $this->assertDeleted($selected_user);
    }
}
