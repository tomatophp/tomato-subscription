<?php

namespace TomatoPHP\TomatoSubscription\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\TomatoSubscription\Models\Plan;
use TomatoPHP\TomatoSubscription\Models\PlanSubscription;
use TomatoPHP\TomatoSubscription\Enums\PlanSubscriptionEnum;

trait HasPlanSubscription
{
    public function planSubscriptions()
    {
        return $this->morphMany(PlanSubscription::class, 'model');
    }

    public function activePlan()
    {
        return $this->planSubscriptions()->where('is_current', 1)
            ->where('status', PlanSubscriptionEnum::ACTIVE)
            ->first();
    }

    public function checkFeature($route): bool
    {
        if (Plan::find($this->activePlan()->plan_id)->features()->firstWhere('key', $route)) {
            return true;
        }

        return false;
    }

    public function subscribedTo($planId): bool
    {
        $plan = Plan::where('id', $planId)->first();

        $subscription = $this->planSubscriptions()->where([
            'plan_id' => $plan->id,
            'is_current' => true,
        ])->first();

        if ($plan->is_free) {
            return true;
        }

        return $subscription && $subscription->active();
    }

    public function newPlanSubscription(Plan $plan, Carbon $startDate = null): PlanSubscription
    {
        $period = new Period($plan->invoice_interval, $plan->invoice_period, $startDate ?? now());

        $account = auth()->user();
        if ($account->planSubscriptions) {
            $account->planSubscriptions()->update(['is_current' => false]);
        }

        return $this->planSubscriptions()->create([
            'plan_id' => $plan->getKey(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate()->subDay()->endOfDay(),
            'status' => PlanSubscriptionEnum::PENDING,
            'is_current' => true,
        ]);
    }

    public function subscribeToDefaultAndFree(Model $model, Plan $plan, Carbon $startDate = null)
    {
        $period = new Period($plan->invoice_interval, $plan->invoice_period, $startDate ?? now());

        return PlanSubscription::create([
            'model_id' => $model->id,
            'model_type' => static::class,
            'plan_id' => $plan->getKey(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate()->subDay()->endOfDay(),
            'status' => PlanSubscriptionEnum::ACTIVE,
            'is_current' => true,
        ]);

    }


}
