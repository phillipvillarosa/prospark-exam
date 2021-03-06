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

        $params = [
            'start' => 0,
            'length' => 20,
            'columns' => [
                [
                    'data' => 'name',
                    'name' => '',
                    'searchable' => '',
                    'orderable' => '',
                    'search' => [
                        'value' => '',
                        'regex' => ''
                    ],

                ]
            ],
            'order' => [
                [ 
                    'column' => 0 ,
                    'dir' => 'asc'
                ]
            ],
            'search' => [
                'value' => ''
            ]
        ];

        $response = $this->json('GET', '/api/users', $params);

        $response->assertOk()
            ->assertJsonStructure([
                'users' => []
            ]);
    }

    public function testStoreNewUser()
    {
        $create_user = $this->postJson('api/users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com',
            'password' => 'bawallumabas'
        ]);

        $create_user->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com'
        ]);
    }

    public function testErrOnStoringExistingUserWithSameEmail()
    {
        $create_user = $this->postJson('api/users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com',
            'password' => 'bawallumabas'
        ]);

        $create_user->assertOk();

        //store same user again with same email
        $create_same_user = $this->postJson('api/users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com',
            'password' => 'bawallumabas'
        ]);

        $create_same_user->assertJsonValidationErrors(['email']);
    }

    public function testShowAUser()
    {
        $selected_user = $this->createUsersAndSelect();

        $response = $this->getJson('api/users/' . $selected_user->id);

        $response->assertOk()
            ->assertJson([
                'user' => $selected_user->toArray()
            ]);
    }

    public function testUpdateAUser()
    {
        $selected_user = $this->createUsersAndSelect();

        $updated_user = $this->patchJson('api/users/' . $selected_user->id, [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com',
        ]);

        $updated_user->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com'
        ]);
    }

    public function testDeleteAUser()
    {
        $selected_user = $this->createUsersAndSelect();

        $delete_user = $this->deleteJson('api/users/' . $selected_user->id);

        $delete_user->assertOk();
        $this->assertDeleted($selected_user);
    }

    public function testSearchingExistingUser()
    {
        $user = $this->createUsersAndSelect();

        $search_user = $this->postJson('api/users/search', [
            'name' => $user->name,
            'email' => $user->email
        ]);

        $search_user->assertOk()
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonFragment(['email' => $user->email]);
    }

    public function testSearchingNonExistingUserReturnsEmptyData()
    {
        $this->fakeUsers();

        $search_user = $this->postJson('api/users/search', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juandc@gmail.com'
        ]);

        $search_user->assertJsonFragment(['data' => []]);
    }
}
