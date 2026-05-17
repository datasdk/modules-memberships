<?php

declare(strict_types=1);

namespace Modules\Memberships\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

use Laravelcm\Subscriptions\Traits\BelongsToPlan;
use DataSDK\Tools\Traits\Slugs\Slugs;
use DataSDK\Tools\Traits\Language;
use DataSDK\Tools\Traits\Sorting;
use DataSDK\Tools\Traits\DateFormat;

use ActionModel;


class Feature extends Model
{

    use HasFactory;
    use Language, Slugs, Dateformat, Sorting;


    protected $table = "memberships_features";
    
 


    protected $fillable = [
        'plan_id',
        'slug',
        'name',
        'description',
        'value',
        'resettable_period',
        'resettable_interval',
        'sorting',
    ];

    
    public $sluggable = 'name';

    protected $casts = [
        'slug' => 'string',
        'value' => 'string',
        'resettable_period' => 'integer',
        'resettable_interval' => 'string',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime',
    ];


    public $translatable = ['name', 'description'];


    public array $sortable = [
        'order_column_name' => 'sort_order',
    ];

    

    public function usages(): HasMany
    {
        return $this->hasMany(config('memberships.models.subscription_usage'));
    }


    public function getResetDate(?Carbon $dateFrom = null): Carbon
    {

        $period = new Period($this->resettable_interval, $this->resettable_period, $dateFrom ?? Carbon::now());

        return $period->getEndDate();

    }

    public static function existsForPlan($plan, string $name): bool
    {

        return $plan->features()
            ->where('name', $name)
            ->exists();

    }

}

