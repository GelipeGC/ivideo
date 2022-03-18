<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->plansList() as $plan) {
            Plan::create([
                'name' => $plan["name"],
                'slug' => $plan["slug"],
                'price' => $plan["price"],
                'is_free' => $plan["is_free"],
                'stripe_id' => $plan["stripe_id"],
                'storage' => $plan["storage"],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }

    protected function plansList()
    {
        return [
            [
                'name' => 'Oro',
                'slug' => 'oro',
                'price' => 1000,
                'is_free' => false,
                'stripe_id' => 'price_1KdQB7CyB0UV0UM5nFio4K77', //id of spripe dashboard
                'storage' => 10000
            ],
            [
                'name' => 'Plata',
                'slug' => 'plata',
                'price' => 500,
                'is_free' => false,
                'stripe_id' => 'price_1KdQBWCyB0UV0UM5CoJKlNBD', //id of spripe dashboard
                'storage' => 5000
            ],
            [
                'name' => 'Gratis',
                'slug' => 'gratis',
                'price' => 0,
                'is_free' => true,
                'stripe_id' => null, //id of spripe dashboard
                'storage' => 500
            ]
        ];
    }
}
