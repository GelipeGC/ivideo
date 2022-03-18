<?php

namespace Tests\Feature\Files;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $files = File::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'default.jpg',
            'uuid' => '12345678'
        ]);
    }

    /** @test */
    function get_all_files_by_current_user()
    {
        $this->actingAs($this->user)
                    ->getJson("{$this->apiPath}/files")
                    ->assertSuccessful()
                    ->assertJson([
                        'data' => [
                            ['uuid' => '12345678', 'name' => 'default.jpg']
                        ]
                    ]);

    }
    /** @test */
    function a_user_can_get_signed_url_to_s3()
    {
        $this->actingAs($this->user)
                    ->postJson("{$this->apiPath}/files/signed",[
                        'name' => 'default.mp4',
                        'extension' => 'mp4'
                    ])
                    ->assertSuccessful();
    }
    /** @test */
    function a_user_can_save_a_video()
    {
        $this->actingAs($this->user)
                    ->postJson("{$this->apiPath}/files/signed",[
                        'name' => 'default.mp4',
                        'extension' => 'mp4'
                    ])
                    ->assertSuccessful();
    }
}
