<?php

declare(strict_types=1);

namespace Modules\Memberships\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Memberships\Services\Period;
use Modules\Memberships\Traits\BelongsToPlan;
use Modules\Memberships\Models\Plan;
use DataSDK\Tools\Traits\Language;
use Modules\Memberships\Models\User;
use DataSDK\Tools\Traits\DateFormat;
use Modules\Memberships\Events\SubscriptionIsRenewed;
use Modules\Memberships\Events\CancelSubscriptionNow;
//use Glorand\Model\Settings\Traits\HasSettingsField;
use Modules\Email\Contracts\Interfaces\HasEmailsInterface;
use Modules\Email\Traits\HasEmails;
use LogicException;



class Subscription extends Model implements HasEmailsInterface
{
    
    use BelongsToPlan;
    use HasFactory;
    use Language;
  //  use SoftDeletes;
    use DateFormat;
 //   use HasSettingsField;
    use HasEmails;


    protected $table = "memberships_subscriptions";
    
    
    protected $appends = [
        'has_trial',
        'status',
        'is_active',
        'is_canceled',
        'is_ended',
        'is_on_trial',
        'is_on_grace',
        'is_canceled_not_ended'
    ];


    protected $fillable = [
        'name',
        'subscribable_id',
        'subscribable_type',
        'plan_id',
        'description',
        'timezone',
        
        'payment_method',
        'payment_status',
        'paid_at',
        
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'auto_renew',
        'trial_auto_upgrade',
        'permanent_membership',
        'cancels_at',
        'canceled_at',
    ];


    protected $casts = [
        'subscribable_type' => 'string',
        'slug' => 'string',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancels_at' => 'datetime',
        'canceled_at' => 'datetime',
        'deleted_at' => 'datetime',
        'paid_at' => 'datetime',
    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'description',
    ];


    public function getStatusAttribute(): string
    {

        if ($this->canceled()) {
            return 'canceled';
        }

        if ($this->ended()) {
            return 'ended';
        }

        if ($this->onGrace()) {
            return 'on_grace';
        }
      
        if ($this->active()) {
            return 'active';
        }

        if ($this->onTrial()) {
            return 'on_trial';
        }
      

        return 'inactive';
        
    }

    public function getHasTrialAttribute(): bool
    {
        return $this->trial_ends_at !== null;
    }


    public function getIsActiveAttribute(): bool
    {
        return $this->active();
    }

    public function getIsCanceledAttribute(): bool
    {
        return $this->canceled();
    }

    public function getIsCanceledNotEndedAttribute(): bool
    {
        return $this->canceled() && !$this->ended();
    }

    public function getIsEndedAttribute(): bool
    {
        return $this->ended();
    }

    public function getIsOnTrialAttribute(): bool
    {
        return $this->onTrial();
    }

    public function getIsOnGraceAttribute(): bool
    {
        return $this->onGrace();
    }

    

    public function subscribable(): MorphTo
    {
        return $this->morphTo('subscribable', 'subscribable_type', 'subscribable_id', 'id');
    }

    

    public function usage(): HasMany
    {
        return $this->hasMany(config('memberships.models.subscription_usage'));
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class,"plan_id");
    }


    public function active(): bool
    {
        return ! $this->ended() || $this->onTrial();
    }


    public function inactive(): bool
    {
        return ! $this->active();
    }



    public function onTrial(): bool
    {
        return $this->trial_ends_at && Carbon::now()->lt($this->trial_ends_at);
    }


    public function canceled(): bool
    {
        return $this->canceled_at && Carbon::now()->gte($this->canceled_at);
    }


    public function ended(): bool
    {
        return $this->ends_at && Carbon::now()->gte($this->ends_at);
    }


    public function cancel(bool $immediately = false): self
    {

        $now = Carbon::now();

        $this->canceled_at = $now;


        if ($immediately) {

            $this->ends_at = $this->canceled_at;

        }



        if($this->trial_ends_at < $now){

            $this->cancels_at = $this->ends_at;

        }

        else

        if(!$this->trial_auto_upgrade){

            $this->cancels_at = $this->trial_ends_at;

        } else {

            $this->cancels_at = $this->ends_at;

        }

        
        $this->save();


        return $this;

    }


    public function changePlan(Plan $plan): self
    {
        // If plans does not have the same billing frequency
        // (e.g., invoice_interval and invoice_period) we will update
        // the billing dates starting today, and since we are basically creating
        // a new billing cycle, the usage data will be cleared.
        if ($this->plan->invoice_interval !== $plan->invoice_interval || $this->plan->invoice_period !== $plan->invoice_period) {
            $this->setNewPeriod($plan->invoice_interval, $plan->invoice_period);
            $this->usage()->delete();
        }

        // Attach new plan to subscription
        $this->plan_id = $plan->getKey();
        $this->save();

        return $this;
    }


    /**
     * Renew subscription period.
     *
     * @return $this
     *
     * @throws LogicException
     */

    public function renew(): self
    {
        if ($this->ended() && $this->canceled()) {
            throw new LogicException('Unable to renew canceled ended subscription.');
        }

        $subscription = $this;

        DB::transaction(function () use ($subscription): void {
            // Clear usage data
            $subscription->usage()->delete();

            // Renew period
            $subscription->setNewPeriod();
            $subscription->canceled_at = null;
            $subscription->save();
        });



        return $this;

    }


    /**
     * Get bookings of the given subscriber.
     */
    public function scopeOfSubscriber(Builder $builder, Model $subscribable): Builder
    {
        return $builder->where('subscribable_type', $subscribable->getMorphClass())
            ->where('subscribable_id', $subscribable->getKey());
    }



    /**
     * Scope subscriptions with ending trial.
     */
    public function scopeFindEndingTrial(Builder $builder, int $dayRange = 3): Builder
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $builder->whereBetween('trial_ends_at', [$from, $to]);
    }


    /**
     * Scope subscriptions with ended trial.
     */
    public function scopeFindEndedTrial(Builder $builder): Builder
    {
        return $builder->where('trial_ends_at', '<=', Carbon::now());
    }


    /**
     * Scope subscriptions with ending periods.
     */
    public function scopeFindEndingPeriod(Builder $builder, int $dayRange = 3): Builder
    {
        $from = Carbon::now();
        $to = Carbon::now()->addDays($dayRange);

        return $builder->whereBetween('ends_at', [$from, $to]);
    }


    /**
     * Scope subscriptions with ended periods.
     */
    public function scopeFindEndedPeriod(Builder $builder): Builder
    {
        return $builder->where('ends_at', '<=', Carbon::now());
    }


    /**
     * Scope all active subscriptions for a user.
     */
    public function scopeFindActive(Builder $builder): Builder
    {
        return $builder->where('ends_at', '>', Carbon::now());
    }


    /**
     * Set new subscription period.
     *
     * @return $this
     */
    protected function setNewPeriod(string $invoice_interval = '', ?int $invoice_period = null, ?Carbon $start = null): self
    {
        if (empty($invoice_interval)) {
            $invoice_interval = $this->plan->invoice_interval;
        }

        if (empty($invoice_period)) {
            $invoice_period = $this->plan->invoice_period;
        }

        $period = new Period(
            interval: $invoice_interval,
            count: $invoice_period,
            start: $start ?? $now = Carbon::now()->endOfDay()
        );

        $this->starts_at = $period->getStartDate();
        $this->ends_at = $period->getEndDate();

        return $this;
    }


    public function recordFeatureUsage(string $featureSlug, int $uses = 1, bool $incremental = true): SubscriptionUsage
    {
        $feature = $this->plan->features()->where('slug', $featureSlug)->first();

        $usage = $this->usage()->firstOrNew([
            'subscription_id' => $this->getKey(),
            'feature_id' => $feature->getKey(),
        ]);

        if ($feature->resettable_period) {
            // Set expiration date when the usage record is new or doesn't have one.
            if ($usage->valid_until === null) {
                // Set date from subscription creation date so the reset
                // period match the period specified by the subscription's plan.
                $usage->valid_until = $feature->getResetDate($this->created_at);
            } elseif ($usage->expired()) {
                // If the usage record has been expired, let's assign
                // a new expiration date and reset the uses to zero.
                $usage->valid_until = $feature->getResetDate($usage->valid_until);
                $usage->used = 0;
            }
        }

        $usage->used = $incremental ? $usage->used + $uses : $uses;

        $usage->save();

        return $usage;
    }


    public function reduceFeatureUsage(string $featureSlug, int $uses = 1): ?SubscriptionUsage
    {
        $usage = $this->usage()->byFeatureSlug($featureSlug, $this->plan_id)->first();

        if ($usage === null) {
            return null;
        }

        $usage->used = max($usage->used - $uses, 0);

        $usage->save();

        return $usage;
    }


    /**
     * Determine if the feature can be used.
     */
    public function canUseFeature(string $featureSlug): bool
    {
        $featureValue = $this->getFeatureValue($featureSlug);
        $usage = $this->usage()->byFeatureSlug($featureSlug, $this->plan_id)->first();

        if ($featureValue === 'true') {
            return true;
        }

        // If the feature value is zero, let's return false since
        // there's no uses available. (useful to disable countable features)
        if (! $usage || $usage->expired() || $featureValue === null || $featureValue === '0' || $featureValue === 'false') {
            return false;
        }

        // Check for available uses
        return $this->getFeatureRemainings($featureSlug) > 0;
    }


    /**
     * Get how many times the feature has been used.
     */
    public function getFeatureUsage(string $featureSlug): int
    {
        $usage = $this->usage()->byFeatureSlug($featureSlug, $this->plan_id)->first();

        return (! $usage || $usage->expired()) ? 0 : $usage->used;
    }


    /**
     * Get the available uses.
     */
    public function getFeatureRemainings(string $featureSlug): int
    {
        return $this->getFeatureValue($featureSlug) - $this->getFeatureUsage($featureSlug);
    }


    public function getFeatureValue(string $featureSlug): ?string
    {
        $feature = $this->plan->features()->where('slug', $featureSlug)->first();

        return $feature->value ?? null;
    }


    public function onGrace(): bool
    {
        $plan = $this->plan;

        // Hvis planen ikke har grace period defineret
        if (! $plan || ! $plan->hasGrace()) {
            return false;
        }

        // Ingen end-dato = ingen grace
        if (! $this->ends_at) {
            return false;
        }

        // Beregn grace-slutdato
        $graceEnd = match ($plan->grace_interval) {
            'day', 'days'   => $this->ends_at->copy()->addDays($plan->grace_period),
            'week', 'weeks' => $this->ends_at->copy()->addWeeks($plan->grace_period),
            'month', 'months' => $this->ends_at->copy()->addMonths($plan->grace_period),
            'year', 'years' => $this->ends_at->copy()->addYears($plan->grace_period),
            default => null,
        };

        if (! $graceEnd) {
            return false;
        }

        // Grace period: mellem ends_at og graceEnd
        return Carbon::now()->gte($this->ends_at) && Carbon::now()->lt($graceEnd);
    }

}
