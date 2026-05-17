<?php

namespace Modules\Memberships\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Memberships\Models\User;
use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Http\Requests\SubscriptionRequest;
use Modules\Memberships\Services\Period;
use Modules\Memberships\Events\SubscriptionCreated;
use Modules\Memberships\Events\SubscriptionUpdated;
use Modules\Memberships\Events\SubscriptionDeleted;
use Modules\Crm\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class SubscriptionsController extends Controller
{
    /**
     * Overview page
     */
    public function index(Request $req)
    {
        if ($resp = $this->checkMembership()) return $resp;

        $subscriptions = Subscription::with(['plan', 'subscribable'])->get();

        return view('memberships::subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show create form
     */
    public function create(Request $req)
    {
        if ($resp = $this->checkMembership()) return $resp;

        return view(
            'memberships::subscriptions.create',
            [
                'plans' => Plan::all(),
                'users' => User::all(),
            ]
        );
    }

    /**
     * Store new subscription
     */
    public function store(SubscriptionRequest $req)
    {
        if ($resp = $this->checkMembership()) return $resp;

        try {
            $plan = Plan::findOrFail($req->plan_id);

            $user = $req->boolean('new_user')
                ? app(UserService::class)->create($req->input('user'))
                : User::findOrFail($req->subscribable_id);

            $startsAt = Carbon::parse($req->starts_at)->startOfDay();

            // Trial
            $trialEndsAt = null;
            if ($req->boolean('has_trial')) {
                $trial = new Period(
                    interval: $req->trial_interval,
                    count: $req->trial_period,
                    start: $startsAt
                );

                $trialEndsAt = $trial->getEndDate();
            }

            // Subscription period
            $period = new Period(
                interval: $req->invoice_interval,
                count: $req->invoice_period,
                start: $trialEndsAt ?? $startsAt
            );

            $subscription = $user->subscriptions()->create([
                'name'                 => 'main',
                'plan_id'              => $plan->id,
                'starts_at'            => $period->getStartDate(),
                'ends_at'              => $req->boolean('permanent_membership')
                    ? null
                    : $period->getEndDate(),
                'trial_ends_at'        => $trialEndsAt,
                'features'             => $req->features ?? [],
                'auto_upgrade'         => $req->boolean('auto_upgrade'),
                'permanent_membership' => $req->boolean('permanent_membership'),
                'payment_method'       => $req->payment_method,
                'payment_status'       => $req->payment_status,
                'paid_at'              => $req->paid_at
                    ? Carbon::parse($req->paid_at)
                    : null,
                'customer'             => $req->customer,
                'auto_renew'           => $req->auto_renew ?? 0,
                'trial_auto_upgrade'   => $req->trial_auto_upgrade ?? 0
            ]);


            // Features
            foreach ($req->features ?? [] as $feature) {
                $subscription->features()->firstOrCreate(['code' => $feature]);
            }


            event(new SubscriptionCreated($subscription));


            return redirect()
                ->route('memberships.subscriptions.index')
                ->with('success', 'Subscription created successfully.');


        } catch (Exception $e) {

            Log::error($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage());

        }

    }


    /**
     * Show single subscription
     */
    public function show(Request $req, $id)
    {

        if ($resp = $this->checkMembership()) return $resp;

        return view(
            'memberships::subscriptions.show',
            ['subscription' => Subscription::findOrFail($id)]
        );

    }

    /**
     * Show edit form
     */
    public function edit(Request $req, $id)
    {

        if ($resp = $this->checkMembership()) return $resp;

        return view(
            'memberships::subscriptions.edit',
            [
                'subscription' => Subscription::findOrFail($id),
                'plans' => Plan::all(),
            ]
        );

    }

    /**
     * Update subscription
     */
    public function update(SubscriptionRequest $req, $id)
    {


        if ($resp = $this->checkMembership()) return $resp;


        $subscription = Subscription::findOrFail($id);

        $data = $req->only([
            'features',
            'auto_upgrade',
            'permanent_membership',
            'payment_method',
            'payment_status',
            'auto_renew',
            'trial_auto_upgrade'
        ]);


        if ($req->filled('paid_at')) {
            $data['paid_at'] = Carbon::parse($req->paid_at);
        }


        if ($req->has('starts_at')) {
            $data['starts_at'] = Carbon::parse($req->starts_at)->startOfDay();
        }


        if ($req->has('ends_at')) {
            $data['ends_at'] = Carbon::parse($req->ends_at)->endOfDay();
        }


        if ($req->boolean('has_trial')) {
            $data['trial_ends_at'] = Carbon::parse($req->trial_ends_at)->endOfDay();
        } else {
            $data['trial_ends_at'] = null;
        }


        if ($req->filled('plan_id') && $req->plan_id != $subscription->plan_id) {
            $data['plan_id'] = $req->plan_id;
        }


        $subscription->update($data);

        event(new SubscriptionUpdated($subscription));


        return redirect()
            ->route('memberships.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');

    }


    /**
     * Delete subscription
     */
    public function destroy(Request $req, $id)
    {


        if ($resp = $this->checkMembership()) return $resp;

        $subscription = Subscription::findOrFail($id);

        $subscription->cancel();


        event(new SubscriptionDeleted($subscription));

        return redirect()
            ->route('memberships.subscriptions.index')
            ->with('success', 'Subscription deleted successfully.');

    }


    /**
     * Membership check
     */
    private function checkMembership()
    {

        $hasMembership = true;


        if (! $hasMembership) {
            return redirect()
                ->route('memberships.subscription')
                ->with('error', 'You must have an active membership.');
        }

        return null;

    }
}
