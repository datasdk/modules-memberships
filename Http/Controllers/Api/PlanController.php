<?php

namespace Modules\Memberships\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Http\Requests\PlanRequest;
use Orion\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

class PlanController extends OrionBaseController
{
    protected $model = Plan::class;
    protected $request = PlanRequest::class;

    protected $includes = [
        "image",
        "images",
        "subscriptions",
        "features",
        "features.categories"
    ];

    protected $exposedScopes = [
        "myPlans",
        "features.categories.childrenAndSelf"
    ];

    /**
     * Opretter en ny plan
     */
    public function store(Request $request)
    {
        $plan = Plan::create($request->validated());

        if ($request->filled('features')) {
            $plan->syncFeatures($request->features);
        }

        if ($request->filled('tags')) {
            $plan->syncTags($request->tags);
        }

        return response()->json($plan->load('features'), 201);
    }

    /**
     * Opdaterer en eksisterende plan
     */
    public function update(Request $request, ...$args)
    {
        $id = $args[0];
        $plan = Plan::findOrFail($id);

        $plan->update($request->validated());

        if ($request->filled('features')) {
            $plan->syncFeatures($request->features);
        }

        if ($request->filled('tags')) {
            $plan->syncTags($request->tags);
        }

        return response()->json($plan->load('features'));
    }

    /**
     * Sletter en plan
     */
    public function destroy(Request $request, ...$args): JsonResponse
    {
        $id = $args[0];
        $plan = Plan::findOrFail($id);

        $plan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully.'
        ], 200);
    }
}
