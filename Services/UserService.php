<?php

namespace Modules\Memberships\Services;

use Modules\Memberships\Models\User;
use Modules\Memberships\Models\Plan;

class UserService
{
    // Fetch the plan for a given user
    public function getUserPlan(User $user, $planName)
    {
        return $user->getPlan($planName);
    }

    // Get all memberships (subscriptions) for a given user
    public function getUserMemberships(User $user)
    {
        return $user->memberships();
    }
}
