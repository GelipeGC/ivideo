<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Requests\SubscriptionSwapRequest;
use App\Http\Repositories\SubscriptionRepository;

class SubscriptionController extends Controller
{
    private $subscription;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(SubscriptionRepository $subscription)
    {
        $this->middleware(['subscribed'])->only('swapSubscription');
        $this->subscription = $subscription;
    }
    public function createSubscription(SubscriptionRequest $request)
    {
        return $this->subscription->create($request);
    }
    public function swapSubscription(SubscriptionSwapRequest $request)
    {
        return $this->subscription->swapSubscription($request);
    }
}
