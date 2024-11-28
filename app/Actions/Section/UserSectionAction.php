<?php

namespace App\Actions\Section;

use App\Exceptions\SubscriptionPlanException;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class UserSectionAction {
    public function use(Section $section)
    {
        $this->validateSectionUse($section);

        // give the required service to the user :eg download a song on local storage
    }

    private function validateSectionUse(Section $section)
    {
        $user = Auth::user();
        if ($section->subscriptionPlan?->priority > $user->subscription?->id ){
            throw new SubscriptionPlanException(
                trans('exceptions.user_does_have_required_subscription_plan',[
                'subscription_name' => $section->subscriptionPlan?->name
                ]));
        }
    }
}