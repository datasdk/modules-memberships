<?php

namespace Modules\Memberships\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Memberships\Models\User;
use Modules\Memberships\Models\Plan;

class NotOnPlan implements Rule
{
    protected ?User $user;

    /**
     * Create a new rule instance.
     *
     * @param User|int $user User model eller user_id
     */
    public function __construct(?int $user_id)
    {
    
        $this->user = User::find($user_id);
    }

    /**
     * Check if validation passes.
     *
     * @param string $attribute
     * @param mixed $value Plan ID
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
   
        if (!$this->user || !$value) {
            return true; // Spring validering hvis user eller plan mangler
        }

        $plan = Plan::find($value);

   
        if (!$plan) {
            return true; // Lad "exists:plans,id" håndtere dette
        }


        // Tjek om brugeren allerede har en aktiv subscription på denne plan
        return !$this->user->activePlanSubscriptions()->contains('plan_id', $plan->id);
    }

    /**
     * Validation error message.
     */
    public function message(): string
    {
        return 'Brugeren er allerede tilmeldt denne plan.';
    }
}
