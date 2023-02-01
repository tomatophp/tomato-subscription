<?php
namespace TomatoPHP\TomatoSubscription\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\TomatoSubscription\Models\Plan;

trait BelongsToPlan
{

    /**
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id', 'plans');
    }


    /**
     * @param Builder $builder
     * @param int $planId
     * @return Builder
     */
    public function scopeByPlanId(Builder $builder, int $planId): Builder
    {
        return $builder->where('plan_id', $planId);
    }
}
