<?php

namespace Modules\Memberships\Services;

use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Subscription;

class PlanService
{
    // Adds feature to the specified plan
    public function addFeatureToPlan($model, Plan $plan)
    {
        // We are now working directly with the Plan object
        $plan->addFeature($model);

        return $model;
    }

    // Get a plan by its slug
    public function getPlanBySlug($slug)
    {
        // Directly fetching the plan by slug
        return Plan::findBySlug($slug);
    }

    // Example method to get the features of a specific plan
    public function getPlanFeatures(Plan $plan)
    {
        // This would return features related to the plan
        return $plan->features; // Assuming 'features' is a relationship on the Plan model
    }
}
