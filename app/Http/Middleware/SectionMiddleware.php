<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\SubscriptionPlanException;
use Symfony\Component\HttpFoundation\Response;

class SectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$section): Response
    {
        $this->validate($section);

        return $next($request);
    }

    private function validate(string $section)
    {
        $user = Auth::user();
        $section = Section::firstWhere('name',$section);
        $subscription = $user->subscription;

        if (empty($subscription))
        {
            throw new SubscriptionPlanException(
                trans('exceptions.user_does_have_any_subscription_plan')
            );
        }
        
        if ($section->subscriptionPlan?->priority > $user->subscription?->subscriptionPlan?->priority ){
            throw new SubscriptionPlanException(
                trans('exceptions.user_does_have_required_subscription_plan',[
                'subscription_name' => $section->subscriptionPlan?->name
                ]));
        }

        if ($user->subscription?->expired_at < now() ){
            throw new SubscriptionPlanException(
                trans('exceptions.users_subscription_is_expired')
            );
        }
    }
}
