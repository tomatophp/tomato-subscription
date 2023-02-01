<?php

namespace TomatoPHP\TomatoSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $key
 * @property string $value
 * @property array $extra
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class PlanFeature extends Model
{
    use HasTranslations;

    /**
     * @var array|string[]
     */
    public array $translatable = ['name', 'description'];

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'key',
        'value',
        'extra',
        'is_active',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'extra' => 'array',
        'is_active' => 'bool',
    ];

    /**
     * @return BelongsToMany
     */
    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_has_features', 'feature_id', 'plan_id')
                ->withPivot('value');
    }
}
