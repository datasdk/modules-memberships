<?php

namespace Modules\Memberships\Listeners;


use Modules\Crm\Events\UserActivated;
use Modules\Memberships\Models\SubscriptionAutoupgrade;
use Modules\Memberships\Services\SubscriptionService;
use Modules\Memberships\Models\User as MemberUser;


class HandleSubscriptionAutoUpgrade
{


    protected SubscriptionService $subscriptionService;


    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }


    
    public function handle(UserActivated $event)
    {
   

        $user = MemberUser::find($event->user->id);

        $autoUpgrade = SubscriptionAutoupgrade::query()
            ->where('event', UserActivated::class)
            ->whereHas('plan')
            ->first();

      
        if ($autoUpgrade) {


            $plan = $autoUpgrade->plan ?? null;
  

            if ($plan) {


                $res = app(SubscriptionService::class)->create([
                    'plan' => $plan,
                    'user' => $user
                ]);

        

            }


        }


    }
}
