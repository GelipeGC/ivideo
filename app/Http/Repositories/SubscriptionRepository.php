<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Http\Support\ResponseActionsTrait;

class SubscriptionRepository
{
    use ResponseActionsTrait;

    protected $model;

    public function __construct(Plan $plan)
    {
        return $this->model = $plan;
    }
    public function create($request)
    {
        $plan = $this->model::whereSlug($request->plan)->first();

        $request->user()->newSubscription('default', $plan->stripe_id)->create($request->token);
    }
    public function swapSubscription($request)
    {
        $plan = $this->model::whereSlug($request->plan)->first();

        if (!$request->user()->canDowngradeToPlan($plan)) {
            return $this->sendFailedResponse('updated', 'Error al cambiar el plan', 400);
        }

        if ($plan->is_free) {
            $request->user()->subscription('default')->cancel();
            return;
        }
        $request->user()->subscription('default')->swap($plan->stripe_id);
    }

}
