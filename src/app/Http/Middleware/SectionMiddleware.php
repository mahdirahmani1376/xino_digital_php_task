<?php

namespace App\Http\Middleware;

use App\Models\Section;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $section)
    {

        $user = Auth::user();
        $section = Section::firstWhere('name', $section);
        $subscription = $user->subscription;

        // dd($user->subscription_id,$subscription->toArray(),$section->toArray());

        if (empty($subscription)) {
            return response()->json([
                'message' => trans('exceptions.user_does_have_any_subscription_plan'),
            ], 404);

        }

        if ($section->subscriptionPlan?->priority > $user->subscription?->subscriptionPlan?->priority) {
            return response()->json([
                'message' => trans('exceptions.user_does_have_required_subscription_plan', [
                    'subscription_name' => $section->subscriptionPlan?->name,
                ]),
            ], 403);
        }

        if ($user->subscription?->expired_at < now()) {
            return response()->json([
                'message' => trans('exceptions.users_subscription_is_expired'),
            ], 403);
        }

        return $next($request);
    }
}
