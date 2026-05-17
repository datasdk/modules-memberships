<?php

namespace Modules\Memberships\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Shop\Events\ShopOrderProductCreate;
use Modules\Memberships\Services\SubscriptionService;
use Modules\Memberships\Models\User;

class HandleCreateSubscription
{


    public function handle(ShopOrderProductCreate $event): void
    {


        $plan = $event->product;
        $orderData = $event->orderData;
        $user_id = $event->customer->id;

        $user = User::findOrFail($user_id);


        $params = [
            'user'           => $user,
            'plan'           => $plan,
            'starts_at'      => now(),
            'payment_method' => 'shop',
            'payment_status' => 'paid',
            'paid_at'        => now()
        ];



        try {


            // Opret subscription
            app(SubscriptionService::class)->create($params);

            
       



        } catch (\Throwable $e) {


            Log::error('HandleCreateSubscription: Failed to create subscription', [
                'user_id'  => $user->id,
                'plan_id'  => $plan->id ?? null,
                'order_id' => $orderData['order_id'] ?? null,
                'message'  => $e->getMessage(),
            ]);


        }


    }


}
