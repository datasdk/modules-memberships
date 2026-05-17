<?php

namespace Modules\Memberships\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Memberships\Models\User;
use Modules\Memberships\Models\Plan;

interface SubscriptionInterface
{
    public function user();

    public function plan();

    public function removeAllFeatures();
}
