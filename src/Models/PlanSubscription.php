<?php

namespace TomatoPHP\TomatoSubscription\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TomatoPHP\TomatoSubscription\Traits\BelongsToPlan;
use TomatoPHP\TomatoSubscription\Traits\Period;

/**
 * @property integer $id
 * @property integer $model_id
 * @property string $model_type
 * @property integer $plan_id
 * @property string $starts_at
 * @property string $ends_at
 * @property boolean $is_current
 * @property string $status
 * @property string $canceled_at
 * @property string $created_at
 * @property string $updated_at
 */
class PlanSubscription extends Model
{
    use BelongsToPlan;

    /**
     * @var string
     */
    protected $table = 'plan_subscription';

    /**
     * @var string[]
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'plan_id',
        'starts_at',
        'ends_at',
        'canceled_at',
        'is_current',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'model_id' => 'integer',
        'model_type' => 'string',
        'plan_id' => 'integer',
        'starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'is_current' => 'boolean'
    ];


    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /**
     * @return MorphTo
     */
    public function subscriber(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }


    /**
     * Check if subscription is active
     *
     * @return bool
     */
    public function active(): bool
    {
        return ! $this->ended() || $this->onTrial();
    }

    /**
     * check if subscription is inactive
     *
     * @return bool
     */
    public function inactive(): bool
    {
        return ! $this->active();
    }

    public function onTrial(): bool
    {
        return $this->trial_ends_at && Carbon::now()->lt($this->trial_ends_at);
    }

    /**
     * Check if subscription is canceled
     *
     * @return bool
     */
    public function canceled(): bool
    {
        return $this->canceled_at && Carbon::now()->gte($this->canceled_at);
    }

    /**
     * Check if subscription period has ended
     *
     * @return bool
     */
    public function ended(): bool
    {
        return $this->ends_at && Carbon::now()->gte($this->ends_at);
    }


    /**
     * @param bool|null $immediately
     * @return $this
     */
    public function cancel(bool|null $immediately = false): static
    {
        $this->canceled_at = Carbon::now();
        if ($immediately) {
            $this->ends_at = $this->canceled_at;
        }

        $this->save();
        return $this;
    }


    public function changePlan(Plan $plan)
    {
        // TODO : change plan implementation
    }


    /**
     * @return Exception|$this
     * @throws Exception
     */
    public function renew(): Exception|static
    {
        if ($this->ended() && $this->canceled()) {
            throw new \Exception('Unable to renew canceled ended subscription');
        }

        DB::transaction(function () {
            // Renew period
            $this->setNewPeriod();
            $this->canceled_at = null;
            $this->save();
        });

        return $this;
    }


    /**
     * @param Builder $builder
     * @param Model $subscriber
     * @return Builder
     */
    public function scopeOfSubscriber(Builder $builder, Model $subscriber): Builder
    {
        return $builder->where('subscriber_id', $subscriber->getKey());
    }


    /**
     * Scope subscriptions with ending trial
     *
     * @param Builder $builder
     * @param int $dayRange
     * @return Builder
     */
    public function scopeFindEndingTrial(Builder $builder, int $dayRange = 3): Builder
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $builder->whereBetween('trial_ends_at', [$from, $to]);
    }

    /**
     * Scope subscriptions with ended trial.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFindEndedTrial(Builder $builder): Builder
    {
        return $builder->where('trial_ends_at', '<=', now());
    }


    /**
     * Scope subscriptions with ending periods
     *
     * @param Builder $builder
     * @param int $dayRange
     * @return Builder
     */
    public function scopeFindEndingPeriod(Builder $builder, int $dayRange = 3): Builder
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $builder->whereBetween('ends_at', [$from, $to]);
    }

    /**
     * Scope subscriptions with ended periods
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFindEndedPeriod(Builder $builder): Builder
    {
        return $builder->where('ends_at', '<=', now());
    }


    /**
     * Scope all active subscriptions for a user.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFindActive(Builder $builder): Builder
    {
        return $builder->where('ends_at', '>', now());
    }


    /**
     * set new subscription period
     *
     * @param string|null $invoiceInterval
     * @param string|null $invoicePeriod
     * @param string|null $start
     * @return $this
     */
    protected function setNewPeriod(
        string|null $invoiceInterval = '',
        string|null $invoicePeriod = '',
        string|null $start = ''
    ): static
    {
        if (empty($invoiceInterval)) {
            $invoiceInterval = $this->plan->invoice_interval;
        }

        if (empty($invoicePeriod)) {
            $invoicePeriod = $this->plan->invoice_period;
        }

        $period = new Period($invoiceInterval, $invoicePeriod, $start);

        $this->starts_at = $period->getStartDate();
        $this->ends_at = $period->getEndDate();

        return $this;
    }
}
