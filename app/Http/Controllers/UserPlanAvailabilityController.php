<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\UserPlanAvailabilityRepository;

class UserPlanAvailabilityController extends Controller
{
    private $planAvailability;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(UserPlanAvailabilityRepository $planAvailability)
    {
        $this->planAvailability = $planAvailability;
    }
    public function getPlans(Request $request)
    {
        return $this->planAvailability->getPlans($request);
    }
}
