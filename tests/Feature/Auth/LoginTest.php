<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    function a_user_admin_can_authenticate_with_valid_credentials()
    {

        $t = $this->postJson("{$this->apiPath}/login", [
            'email' => $this->user->email,
            'password' => 'password'
        ])
        ->assertSuccessful()
        /* ->assertJsonStructure(['token', 'expires_in'])
        ->assertJson(['token_type' => 'bearer']) */;
        $t->dump();
    }
}
