<?php

namespace Modules\Memberships\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use Modules\Memberships\Http\Requests\MembershipSettingsRequest;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\SubscriptionAutoupgrade;
use Settings;


class MembershipSettingsController extends Controller
{


    public function index()
    {

        // Hent eksisterende autoupgrade plan for UserActivated event
        $autoupgrade = SubscriptionAutoupgrade::where('event', \Modules\Crm\Events\UserActivated::class)->first();

        $membershipSettings = [
            'autoupgrade_plan_id' => $autoupgrade?->plan_id ?? null,
        ];

        $plans = Plan::all();

        return view('memberships::settings.memberships', compact('membershipSettings', 'plans'));

    }


    public function store(MembershipSettingsRequest $request)
    {


        // Gem autoupgrade plan for UserActivated event
        SubscriptionAutoupgrade::updateOrCreate(
            ['event' => \Modules\Crm\Events\UserActivated::class], // altid denne event
            ['plan_id' => $request->autoupgrade_plan_id]
        );

        return redirect()->route('memberships.settings.index')
            ->with('success', 'Membership settings updated successfully.');

    }
}
