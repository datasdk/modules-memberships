<?php

declare(strict_types=1);

namespace Modules\Memberships\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface PlanInterface
{
    // Features relation
    public function features();

    // Subscription relation
    public function subscriptions();

    // Status checks
    public function isFree();
    public function hasTrial();
    public function hasGrace();

    // Feature retrieval
    public function getFeatureBySlug(string $featureSlug);

    // Activation / deactivation
    public function activate();
    public function deactivate();

    // Feature management
    public function hasFeature($feature);
    public function addFeature(string $code, string $categoryName = "feature");
    public function addFeatures(array $codes);
    public function removeAllFeatures();

    // Scopes
    public function scopeMyPlans($query);

    // Finders
    public static function findByName(string $planName);
    public static function findBySku(string $sku);
}
