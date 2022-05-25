<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\File;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Plan::factory()->create([
            'name' => 'Oro',
            'slug' => 'oro',
            'price' => 1000,
            'is_free' => 0,
            'stripe_id' => 'price_1KdQB7CyB0UV0UM5nFio4K77'
        ]);
        Plan::factory()->create([
            'name' => 'plata',
            'slug' => 'plata',
            'price' => 500,
            'is_free' => 0,
            'stripe_id' => 'price_1KdQBWCyB0UV0UM5CoJKlNBD'
        ]);
        Plan::factory()->create([
            'name' => 'Gratis',
            'slug' => 'gratis',
            'price' => 0,
            'is_free' => 1,
            'stripe_id' => null
        ]);
        \DB::table('subscriptions')->insert([
            'user_id' => $this->user->id,
            'name' => 'default',
            'stripe_id' => 'sub_1L1vpYCyB0UV0UM57eNpmhQb',
            'stripe_status' => 'active',
            'stripe_price' => 'price_1KdQB7CyB0UV0UM5nFio4K77'
        ]);

    }
    /** @test */
    function a_user_can_fetch_current_info()
    {
        $this->actingAs($this->user)
                    ->getJson("{$this->apiPath}/user")
                    ->assertSuccessful()
                    ->assertJson([
                        'plan' => [
                            'name' => 'Oro'
                        ]
                    ]);
    }
    /** @test */
    function a_user_can_get_plans_down_grade()
    {
        $this->actingAs($this->user)
                ->getJson("{$this->apiPath}/subscriptions/plans")
                ->assertSuccessful();
    }
    /** @test */
    function a_user_swap_subscriptions()
    {
        $this->actingAs($this->user)
                ->patchJson("{$this->apiPath}/subscriptions/swap",[
                    'plan' => 'plata'
                ])
                ->assertSuccessful();
    }
    /** @test */
    function the_plan_to_swap_exists()
    {
        $this->actingAs($this->user)
                ->patchJson("{$this->apiPath}/subscriptions/swap",[
                    'plan' => 'no-exist'
                ])
                ->assertStatus(422);
    }
    /** @test */
    function the_user_cannot_swap_to_free_plan_when_maximun_usage()
    {
        $files = File::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'default.jpg',
            'uuid' => '12345678',
            'size' => 11000,
        ]);
        $this->actingAs($this->user)
                ->patchJson("{$this->apiPath}/subscriptions/swap",[
                    'plan' => 'gratis'
                ])
                ->assertStatus(400);
    }
    /** @test */
    function the_user_cannot_swap_plan_if_has_not_subscription_active()
    {
        \DB::table('subscriptions')->delete();
        \DB::table('subscription_items')->delete();
        $this->actingAs($this->user)
                ->patchJson("{$this->apiPath}/subscriptions/swap",[
                    'plan' => 'plata'
                ])
                ->assertStatus(400);
    }

}
