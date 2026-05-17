<?php

namespace Modules\Memberships\Observers;

use App\Models\User;
use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Services\SubscriptionService;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user)
    {
        try {
            // Hent alle abonnementer for denne bruger via subscribable_id
            $subscriptions = Subscription::where('subscribable_id', $user->id)->get();

            foreach ($subscriptions as $subscription) {
                try {
                    $this->subscriptionService->delete($subscription->id);
                } catch (\Exception $e) {
                    Log::error("Failed to delete subscription ID {$subscription->id} for deleted user ID {$user->id}: {$e->getMessage()}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to process subscriptions for deleted user ID {$user->id}: {$e->getMessage()}");
        }
    }
}
