<?php

namespace Modules\Memberships\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Subscription;

interface HasPlanSubscriptionsInterface
{
    
    /**
     * Hent alle abonnementer knyttet til modellen.
     */
    public function planSubscriptions();

    /**
     * Hent alle aktive abonnementer.
     */
    public function activePlanSubscriptions();

    /**
     * Hent et specifikt abonnement ud fra navn.
     */
    public function planSubscription(string $name);

    /**
     * Hent alle planer modellen er tilmeldt.
     */
    public function subscribedPlans();

    /**
     * Tjek om modellen er tilmeldt en bestemt plan-id.
     */
    public function subscribedTo(int $planId);

    /**
     * Opret et nyt abonnement for modellen på en given plan.
     */
    public function newPlanSubscription(string $subscription, Plan $plan, ?Carbon $startDate = null);

}
