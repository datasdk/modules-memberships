<?php

namespace Modules\Memberships\Models;

use App\Models\User as BasicUser;

use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Traits\HasPlanSubscriptions;
use Modules\Memberships\Contracts\HasPlanSubscriptionsInterface;



class User extends BasicUser implements HasPlanSubscriptionsInterface{


    use HasPlanSubscriptions;
    

    public function getPlan($planName)
    {
        if(!$plan = Plan::where("slug",$planName)->first()){
            return false;
        } 
        
       // $isSubscription = $this->active()->where("plan_id", $plan->id)->exists(); aktiv virker???
       $isSubscription = $this->onPlan($plan);

        if($isSubscription){

            return $plan;
        }

        return null;

    }


   
   
    public function subscription()
    {
        return $this->subscriptions();
    }


    public function memberships()
    {
        return $this->subscriptions();
    }


    public function subscriptions()
    {
     
        return $this->morphMany(Subscription::class, 'subscribable')
            ->latest('id');
    }


}
