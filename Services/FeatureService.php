<?php

namespace Modules\Memberships\Services;

use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Models\Plan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeatureService
{
    // Check if the feature is accessible for the model by the current user
    public function isFeatureAccessible($model)
    {
        $code = $this->getFeatureCode($model);

        if ($user = request()->user()) {
            $userId = $user->id;
            $result = DB::table('subscriptions')
                ->select('*', 'subscriptions.id AS id', 'subscriptions.deleted_at AS deleted_at')
                ->join('memberships_plans', 'memberships_plans.plan_id', '=', 'subscriptions.plan_id')
                ->join('subscription_features', 'subscription_features.subscription_id', '=', 'subscriptions.id')
                ->where('subscription_features.code', $code)
                ->where('subscriptions.subscribable_id', $userId)
                ->whereNull('subscriptions.deleted_at')
                ->where(function ($q) {
                    $q->whereNull('subscriptions.ends_at')
                      ->orWhereDate('subscriptions.ends_at', '>', Carbon::now());
                })
                ->exists();

            return $result;
        }

        return true; // Standard: Limited access
    }

    // Generate the feature code for a model
    public function getFeatureCode($model)
    {
        return "model." . $model->getTable() . "." . $model->id;
    }
}
