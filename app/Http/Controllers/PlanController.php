<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PlanRepository;

class PlanController extends Controller
{
    private $planRepository;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(PlanRepository $plan)
    {
        $this->planRepository = $plan;
    }
    public function getPlans()
    {
        return $this->planRepository->all();
    }
}
