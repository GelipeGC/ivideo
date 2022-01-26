<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    protected $defaultData = [
        'name' => 'Felipe Guzman',
        'email' => 'felipe@test.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ];
    /** @test */
    public function a_user_guest_can_register()
    {
        $this->postJson("{$this->apiPath}/register", $this->defaultData())
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['id', 'name', 'email'] ]) ;

        $this->assertCredentials([
            'name' => 'Felipe Guzman',
            'email' => 'felipe@test.com',
            'password' => '12345678',
        ]);
    }

    /** @test */
    function a_user_can_not_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'felipe@test.com'
        ]);

        $this->postJson("{$this->apiPath}/register", $this->defaultData())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    /** @test */
    function the_name_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson("{$this->apiPath}/register", $this->withData([
            'name' => '',

        ]))
        ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson("{$this->apiPath}/register", $this->withData([
            'email' => '',

        ]))
        ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_email_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->postJson("{$this->apiPath}/register", $this->withData([
            'email' => 'invalid-email',

        ]))
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseEmpty('users');
    }
    /** @test */
    function the_password_is_required()
    {
        $this->handleValidationExceptions();

        $this->postJson("{$this->apiPath}/register", $this->withData([
            'password' => '',

        ]))
        ->assertJsonValidationErrors(['password']);

        $this->assertDatabaseEmpty('users');
    }
}
