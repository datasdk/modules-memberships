<?php

declare(strict_types=1);

namespace Modules\Memberships\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelcm\Subscriptions\Traits\HasSlug;
use Laravelcm\Subscriptions\Traits\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

use Modules\Media\Contracts\HasMedia;
use Modules\Memberships\Contracts\PlanInterface;
use DataSDK\Tools\Traits\Language;

use Modules\Media\Traits\InteractsWithMedia;
use DataSDK\Tools\Traits\DateFormat;
use Spatie\Tags\HasTags;
use DataSDK\Tools\Traits\Sorting;
use Modules\Memberships\Models\Feature;

use Modules\Shop\Contracts\ProductContract;



use ActionModel;


class Plan extends ActionModel implements HasMedia, ProductContract 
{

    use HasFactory;
    use HasTags;
    use InteractsWithMedia;



    protected $table = "memberships_plans";

    public $sluggable = 'title';

    public $translatable = ['title','description','slug'];


    protected $fillable = [
        'title',
        'description',
        'slug',
        'description',
        'active',
        'price',
        'signup_fee',
        'active',
        'permanent_membership',
        'currency',
        'has_trial',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit'
    ];


    protected $casts = [
        'price' => 'float',
        'signup_fee' => 'float',
        'deleted_at' => 'datetime'
    ];

 
 

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($plan): void {
            $plan->features()->delete();
            $plan->subscriptions()->delete();
        });
    }


 


    public function features(): HasMany
    {
        return $this->hasMany(Feature::class,"plan_id");
    }


    public function subscriptions(): HasMany
    {
        return $this->hasMany(config('memberships.models.subscription'));
    }


    public function isFree(): bool
    {
        return $this->price <= 0.00;
    }


    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }


    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }



    public function activate(): self
    {
        $this->update(['active' => true]);

        return $this;
    }


    public function deactivate(): self
    {
        $this->update(['active' => false]);

        return $this;
    }


    /**
     * ✅ Tilføjer features til denne plan — kun hvis de ikke allerede findes
     */

    public function syncFeatures($features)
    {

       return $this->addFeatures($features,$sync = true);

    }


    public function addFeatures($features,$sync = false)
    {

        if($sync){ 
            
            $this->removeAllFeactures(); 

        }


        collect($features)->each(function ($featureData) {
            if (!is_array($featureData)) {
                $featureData = ['slug' => $featureData];
            }

            // Tjek om feature allerede findes for denne plan
            if (!Feature::findBySlug($featureData['slug'])) {

                $this->features()->create($featureData);

            }
        });


        return $this->load('features');

    }


    public function removeAllFeactures(){
        
        return $this->features()->delete();

    }


 

}
