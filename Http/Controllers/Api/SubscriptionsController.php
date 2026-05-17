<?php

namespace Modules\Memberships\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Orion\Http\Requests\Request;
use Modules\Memberships\Models\User;
use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Http\Requests\SubscriptionRequest;
use Modules\Memberships\Services\Period;
use Modules\Crm\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Memberships\Events\SubscriptionCreated;
use Modules\Memberships\Events\SubscriptionUpdated;
use Modules\Memberships\Events\SubscriptionDeleted;

class SubscriptionsController extends OrionBaseController
{
    protected $model = Subscription::class;
    protected $request = SubscriptionRequest::class;

    protected $includes = [
        'plan',
        'subscribable',
    ];

    /**
     * Create subscription (API)
     */
    public function store(Request $req)
    {
        try {
            $plan = Plan::findOrFail($req->plan_id);

            $user = $req->boolean('new_user')
                ? app(UserService::class)->create($req->input('user'))
                : User::findOrFail($req->subscribable_id);

            $startsAt = Carbon::parse($req->starts_at ?? now())->startOfDay();

            /**
             * Trial
             */
            $trialEndsAt = null;
            if ($req->boolean('has_trial')) {
                $trial = new Period(
                    interval: $req->trial_interval,
                    count: $req->trial_period,
                    start: $startsAt
                );

                $trialEndsAt = $trial->getEndDate();
            }

            /**
             * Subscription period
             */
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
            ]);

            // Attach features
            foreach ($req->features ?? [] as $feature) {
                $subscription->features()->firstOrCreate(['code' => $feature]);
            }

            event(new SubscriptionCreated($subscription));

            return response()->json($subscription->load($this->includes), 201);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update subscription (API)
     */
    public function update(Request $req, ...$args)
    {
        try {
            $id = $args[0];

            $subscription = Subscription::findOrFail($id);

            $data = $req->only([
                'features',
                'auto_upgrade',
                'permanent_membership',
                'payment_method',
                'payment_status',
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

            if ($req->has('has_trial')) {
                $data['trial_ends_at'] = $req->boolean('has_trial')
                    ? Carbon::parse($req->trial_ends_at)->endOfDay()
                    : null;
            }

            if ($req->filled('plan_id') && $req->plan_id !== $subscription->plan_id) {
                $data['plan_id'] = $req->plan_id;
            }

            $subscription->update($data);

            event(new SubscriptionUpdated($subscription));

            return response()->json(
                $subscription->refresh()->load($this->includes),
                200
            );

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete subscription (API)
     */
    public function destroy(Request $req, ...$args)
    {
        
        try {

            $id = $args[0];

            $subscription = Subscription::findOrFail($id);

            $subscription->cancel();

            event(new SubscriptionDeleted($subscription));

            return response()->noContent();


        } catch (Exception $e) {

            Log::error($e);

            return response()->json([
                'message' => 'Subscription deletion failed',
            ], 500);

        }
    }
}
