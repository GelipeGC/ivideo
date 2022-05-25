<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Http\Resources\PlanResource;
use Illuminate\Support\Facades\Request;
use App\Http\Support\ResponseActionsTrait;

class UserPlanAvailabilityRepository
{
    use ResponseActionsTrait;

    protected $model;

    public function __construct(Plan $plan)
    {
        return $this->model = $plan;
    }
    public function getPlans($request)
    {
        $plans = $this->model::orderBy('storage')->get()->flatMap(function($plan) use($request) {
            return [
                array_merge(
                    (new PlanResource($plan))->toArray($request),
                    ['can_downgrade' => $request->user()->canDowngradeToPlan($plan)]
                )
            ];
        });

        return $this->sendSuccessfullyResponse('success', 'Planes obtenidos con éxito', 200, $plans);
    }
}
