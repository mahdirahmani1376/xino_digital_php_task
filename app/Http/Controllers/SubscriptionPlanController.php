<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return SubscriptionPlan::all();
    }
}
