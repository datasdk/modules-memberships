<?php

namespace Modules\Memberships\Services;

use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Models\User as MemberUser;
use Carbon\Carbon;
use Modules\Memberships\Models\Plan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Modules\Memberships\Models\User;
use Modules\Memberships\Events\SubscriptionCreated;
use Modules\Memberships\Events\SubscriptionUpdated;
use Modules\Memberships\Events\SubscriptionDeleted;
use Modules\Memberships\Services\Period;


class SubscriptionService
{
    

    public function create(array $params): ?Subscription
    {

        $user = $params['user'] ?? null;
        $plan = $params['plan'] ?? null;
        $subscriptionName = $params['name'] ?? "main";


   
        if (!$user || !$plan || !$user->exists) {
            Log::warning("SubscriptionService: Tried to create subscription for invalid or non-existing user.");
            return null;
        }


        $startsAt               = isset($params['starts_at']) ? Carbon::parse($params['starts_at']) : Carbon::now();
        $features               = $params['features'] ?? [];
        $paymentMethod          = $params['payment_method'] ?? null;
        $paymentStatus          = $params['payment_status'] ?? 'pending';
        $paidAt                 = $params['paid_at'] ?? null;
        $auto_renew             = $params['auto_renew'] ?? $plan["auto_renew"];
        $trial_auto_upgrade     = $params['trial_auto_upgrade'] ?? $plan["trial_auto_upgrade"];
        $permanent_membership   = $params['permanent_membership'] ?? $plan["permanent_membership"];


        // Tjek om brugeren allerede har denne plan
        if ($subscription = $user->getPlan($plan->id)) {

            // Tilføj eventuelle nye features
            $plan->features()->get()->map(function ($feature) use ($subscription) {
                $subscription->features()->firstOrCreate(['code' => $feature->code]);
            });

        } else {


            // Opret trial-perioden
            $trial = new Period(
                interval: $plan->trial_interval,
                count: $plan->trial_period,
                start: $startsAt
            );

            // Opret selve abonnementsperioden
            $period = new Period(
                interval: $plan->invoice_interval,
                count: $plan->invoice_period,
                start: $trial->getEndDate()
            );


            // Opret subscription i DB
            $subscription = $user->planSubscriptions()->create([
                'name'                  => $subscriptionName,
                'plan_id'               => $plan->getKey(),
                'trial_ends_at'         => $trial->getEndDate(),
                'starts_at'             => $period->getStartDate(),
                'ends_at'               => $period->getEndDate(),
                'features'              => $features,
                'auto_renew'            => $auto_renew,
                'trial_auto_upgrade'    => $trial_auto_upgrade,
                'permanent_membership'  => $permanent_membership,
                'payment_method'        => $paymentMethod,
                'payment_status'        => $paymentStatus,
                'paid_at'               => $paidAt,
            ]);


            // Tilføj features til subscription
            foreach ($features as $feature) {
                $subscription->features()->firstOrCreate(['code' => $feature]);
            }

        }


        // Trigger event
        event(new SubscriptionCreated($subscription));


        return $subscription;


    }


    public function update(Subscription $subscription,array $params): ?Subscription
    {

        
  
        //subscribable skal måske være der så brugeren kan skiftes

    

        $subscription->update(
            collect($params)->only([
                'plan_id',
                'starts_at',      
                'features',       
                'period',            
                "trial_ends_at",                 
                "ends_at",        
                "auto_upgrade",    
                "trial_ends_at",   
                'trial',       
                'payment_method',  
                'payment_status',   
                'paid_at',                 
            ])->toArray()
        );
            
        

        return $subscription->refresh();

    }


    public function delete(int $subscription_id): bool
    {

        $subscription = Subscription::find($subscription_id);


        if (!$subscription) {

            Log::warning("SubscriptionService: Tried to delete non-existing subscription (ID: $subscription_id)");

            return false;

        }


        $subscribable =  $subscription->subscribable;


        $subscription->cancel();


    
        event(new SubscriptionDeleted($subscription));


        return true;

    }


    public function isUserSubscribedToPlan(int $user_id, string $planName)
    {

        $user = $this->getUserMember($user_id);


        if (!$user) {
            Log::warning("SubscriptionService: Cannot check plan subscription, user not found (ID: $user_id)");
            return false;
        }


        $plan = Plan::where('slug', $planName)->first();


        if (!$plan) {
            Log::warning("SubscriptionService: Plan not found with name '$planName'");
            return false;
        }


        return $user->subscribed();

    }


    public function getUserSubscriptions(int $user_id)
    {

        $user = $this->getUserMember($user_id);

        if (!$user) {

            Log::warning("SubscriptionService: Cannot get subscriptions, user not found (ID: $user_id)");

            return collect();

        }

        return $user->subscriptions()->get();

    }


    public function getActiveSubscription(int $user_id)
    {

        $user = $this->getUserMember($user_id);


        if (!$user) {

            Log::warning("SubscriptionService: Cannot get active subscription, user not found (ID: $user_id)");

            return null;

        }

        return $user->subscriptions()
            ->whereNull('ends_at')
            ->latest('id')
            ->first();

    }


    private function calculateEndDate($startsAt, $period)
    {

        if (!$startsAt) {
            $startsAt = Carbon::now();
        }


        $endDate = Carbon::parse($startsAt);


        if (strpos($period, 'month') !== false) {
            $monthCount = (int) filter_var($period, FILTER_SANITIZE_NUMBER_INT);
            $endDate = $endDate->addMonths($monthCount);
        }


        if (strpos($period, 'year') !== false) {
            $yearCount = (int) filter_var($period, FILTER_SANITIZE_NUMBER_INT);
            $endDate = $endDate->addYears($yearCount);
        }


        return $endDate->endOfDay();

    }


    private function getUserMember(int $user_id): ?MemberUser
    {

        $user = MemberUser::find($user_id);


        if (!$user) {

            Log::warning("SubscriptionService: User not found (ID: $user_id)");

            return null;

        }

        return $user;

    }


    public function isPaused(int $user_id, string $planName)
    {


        $user = $this->getUserMember($user_id);


        if (!$user) {
            Log::warning("SubscriptionService: Cannot check if paused, user not found (ID: $user_id)");
            return false;
        }


        $plan = Plan::where('slug', $planName)->first();


        if (!$plan) {
            Log::warning("SubscriptionService: Cannot check if paused, plan not found ('$planName')");
            return false;
        }


        return $user->subscriptions()
            ->where('plan_id', $plan->id)
            ->whereNotNull('paused_at')
            ->exists();

    }


   

}
