<?php

namespace Modules\Memberships\Traits;

use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait Memberships
{
    private array $memberships = [];

    /**
     * Tilføj en eller flere memberships til modellen
     */
    public function addToMemberships($memberships): static
    {
        
        if (!$memberships) {
            return $this;
        }

        
        // Konverter til array, hvis input kun er ét ID
        $memberships = is_array($memberships) ? $memberships : [$memberships];


        foreach ($memberships as $membershipId) {

            if ($plan = Plan::find($membershipId)) {

                $plan->addFeature($this);

            }

        }

        return $this;

    }

    /**
     * Hent unikt kode-attribut for modellen
     */
    public function getCodeAttribute(): string
    {

        return "model.{$this->getTable()}.{$this->id}";

    }

    /**
     * Hent unikt feature-attribut for brugeren
     */
    public function getFeatureAttribute(): ?string
    {

        if (!$user = request()->user()) {
            return null;
        }

        return "feature.user.{$user->id}." . $this->getCodeAttribute();

    }

    /**
     * Tjek om modellen har adgang via abonnementer
     */
    public function getAccessibleAttribute(): bool
    {

        if (!$user = request()->user()) {
            return true; // Standardadgang, hvis der ikke er en bruger (Limited Access)
        }

        $code = $this->getCodeAttribute();
        $cacheKey = $this->getFeatureAttribute();

        // Tjek om feature eksisterer
        if (!DB::table('features')->where('code', $code)->exists()) {
            return true;
        }

        // Tjek om abonnementer giver adgang
        return DB::table('subscriptions')
            ->join('plan_feature', 'plan_feature.plan_id', '=', 'subscriptions.plan_id')
            ->join('subscription_features', 'subscription_features.subscription_id', '=', 'subscriptions.id')
            ->where('subscription_features.code', $code)
            ->where('subscriptions.subscribable_id', $user->id)
            ->whereNull('subscriptions.deleted_at')
            ->where(function ($q) {
                $q->whereNull('subscriptions.ends_at')
                  ->orWhereDate('subscriptions.ends_at', '>', Carbon::now());
            })
            ->exists();

    }

}
