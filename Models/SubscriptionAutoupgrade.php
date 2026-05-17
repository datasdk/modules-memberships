<?php

namespace Modules\Memberships\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Memberships\Models\Plan;


class SubscriptionAutoupgrade extends Model
{

    protected $table = 'memberships_autoupgrade';

    protected $fillable = [
        'subscription_id', 
        'event',
        'plan_id'
    ];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

}
