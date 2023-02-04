<?php
namespace TomatoPHP\TomatoSubscription\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array $name
 * @property array $description
 * @property double $price
 * @property int $order
 * @property string $invoice_period
 * @property bool $is_recurring
 * @property bool $is_active
 * @property bool $is_free
 * @property bool $is_default
 * @method isActive
 * @method defaultAndFree
 */
class Plan extends Model
{
    use HasTranslations;

    /**
     * @var array|string[]
     */
    public array $translatable = ['name', 'description'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'order',
        'invoice_period',
        'invoice_interval',
        'is_recurring',
        'is_active',
        'is_free',
        'is_default',
        'color',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_recurring' => 'bool',
        'is_active' => 'bool',
        'is_free' => 'bool',
        'is_default' => 'bool',
    ];


    /**
     * @return mixed
     */
    public function users(): mixed
    {
        return $this->morph();
    }

    /**
     * @return BelongsToMany
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(PlanFeature::class, 'plan_has_features', 'plan_id', 'feature_id')
            ->withPivot('value');
    }


    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsActive(): Builder
    {
        return $this->where('is_active', true);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefaultAndFree(Builder $query): Builder
    {
        return $query->where([
            'is_free' => true,
            'is_default' => true,
        ]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFreePlan(): Builder
    {
        return $this->where('is_free', true);
    }

    /**
     * @return $this
     */
    public function activate(): static
    {
        $this->update(['is_active' => true]);
        return $this;
    }

    /**
     * @return $this
     */
    public function deactivate(): static
    {
        $this->update(['is_active' => false]);
        return $this;
    }
}
