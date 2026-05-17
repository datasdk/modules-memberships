<?php

declare(strict_types=1);

namespace Modules\Memberships\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionUsage extends Model
{

    use HasFactory;
   // use SoftDeletes;

    
    protected $table = 'memberships_usage';


    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'valid_until',
    ];

    
    protected $casts = [
        'used' => 'integer',
        'valid_until' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function feature(): BelongsTo
    {

        return $this->belongsTo(config('memberships.models.feature'), 'feature_id', 'id', 'feature');

    }


    public function subscription(): BelongsTo
    {

        return $this->belongsTo(config('memberships.models.subscription'), 'subscription_id', 'id', 'subscription');

    }


    public function scopeByFeatureSlug(Builder $builder, string $featureSlug, int $planId): Builder
    {

        $model = config('memberships.models.feature', Feature::class);
        $feature = $model::where('plan_id', $planId)->where('slug', $featureSlug)->first();

        return $builder->where('feature_id', $feature ? $feature->getKey() : null);

    }


    public function expired(): bool
    {
        if (! $this->valid_until) {
            return false;
        }

        return Carbon::now()->gte($this->valid_until);
    }

}
