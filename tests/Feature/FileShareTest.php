<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use App\Models\FileShare;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileShareTest extends TestCase
{
    protected $user, $file;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->file = File::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'default.jpg',
            'uuid' => '12345678'
        ]);
    }
    /** @test */
    function a_user_can_create_a_link()
    {
        $this->actingAs($this->user)
            ->postJson("{$this->apiPath}/file/{$this->file->uuid}/share")
            ->assertSuccessful();
    }
    /** @test */
    function a_user_can_download_file()
    {
        $fileShare = FileShare::factory()->create([
            'file_id' => $this->file->id
        ]);

        $this->actingAs($this->user)
            ->getJson("{$this->apiPath}/file/{$this->file->uuid}/download?token={$fileShare->token}")
            ->assertSuccessful();
    }
}
