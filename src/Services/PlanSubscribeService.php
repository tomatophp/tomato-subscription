<?php

namespace TomatoPHP\TomatoSubscription\Services;

use Io3x1\TomatoResource\Services\Components\Model;
use TomatoPHP\TomatoSubscription\Models\Plan;
use RuntimeException;

class PlanSubscribeService
{
    public function makeSubscribe(Model $account, Plan $plan)
    {
        if ($this->checkUserIsSubscribedToThisPlan($account, $plan)) {
            throw new RuntimeException('You have already subscribed to this plan');
        }
        return $this->subscribe($account, $plan);
    }

    /**
     * @param Model $account
     * @param Plan $plan
     * @return bool
     */
    public function checkUserIsSubscribedToThisPlan(Model $account, Plan $plan): bool
    {
        return $account->subscribedTo($plan->id);
    }


    public function subscribe(Model $account, Plan $plan)
    {
        return $account->newPlanSubscription($plan);
    }

    public function subscribeToDefaultAndFreePlan(Model $account, Plan $plan)
    {
        return $account->subscribeToDefaultAndFree($account, $plan);
    }
}
