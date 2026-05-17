<?php

declare(strict_types=1);

namespace Modules\Memberships\Observers;

use Modules\Memberships\Models\Feature;
use InvalidArgumentException;

class FeatureObserver
{
    /**
     * Når et feature bliver oprettet
     */
    public function creating(Feature $feature): void
    {
        
        if (
            Feature::where('plan_id', $feature->plan_id)
                ->where('slug', $feature->slug)
                ->exists()
        ) {
            throw new InvalidArgumentException(
                'Each plan should only have one feature with the same slug.'
            );
        }

    }

    /**
     * Når et feature bliver slettet
     */
    public function deleted(Feature $feature): void
    {

        if ($feature->usages()->exists()) {

            $feature->usages()->delete();

        }

    }
}
