<?php

namespace TomatoPHP\TomatoSubscription\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanFeature;
use ProtoneMedia\Splade\Facades\Toast;

class UserHasBeenSubscribedToPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        if (!$user->activePlan()) {
            Toast::danger('Please Subscribe To a plan first')->autoDismiss(2);
            return to_route('admin.plans.index');
        }

        if ($user->checkFeature($request->route()->getName() ?: $request->route()->uri)) {
            return $next($request);
        }

        Toast::danger('Sorry your plan do not support this feature please upgrade your plan')->autoDismiss(2);
        return to_route('admin.plans.index');

    }
}
