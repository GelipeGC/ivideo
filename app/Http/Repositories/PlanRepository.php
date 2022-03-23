<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Http\Resources\PlanResource;

class PlanRepository
{
    protected $model;

    public function __construct(Plan $plan)
    {
        return $this->model = $plan;
    }
    public function all()
    {
        return PlanResource::collection($this->model::orderBy('storage')->get());
    }
}
