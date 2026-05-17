<?php

namespace Modules\Memberships\Http\Controllers;

use Modules\Memberships\Models\Plan;
use App\Http\Controllers\OrionBaseController;
use Modules\Memberships\Http\Requests\PlanRequest;
use Orion\Http\Requests\Request;

class PlanController extends OrionBaseController
{

    protected $model = Plan::class;

    protected $request = PlanRequest::class;


    protected $includes = [
        // "image",
        // "images",
        "subscriptions",
        "features",
        "features.categories"
    ];

    protected $exposedScopes = [
        "myPlans",
        "features.categories.childrenAndSelf"
    ];


    /**
     * Vis liste over planer
     */
    public function index(Request $request)
    {

        $plans = Plan::with($this->includes)->get();

        return view('memberships::plans.index', compact('plans'));

    }

    /**
     * Vis formular for ny plan
     */
    public function create(Request $request)
    {

        return view('memberships::plans.create');

    }

    /**
     * Vis detaljer for en plan
     */
    public function show(Request $request, ...$args)
    {
        
        $plan = Plan::with($this->includes)->findOrFail($args[0]);

        return view('memberships::plans.show', compact('plan'));

    }

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


        return redirect()
            ->route('memberships.plans.index')
            ->with('success', 'Planen er oprettet.');

    }


    /**
     * Vis formular for redigering
     */
    public function edit(Request $request, ...$args)
    {

        $plan = Plan::with($this->includes)->findOrFail($args[0]);

        return view('memberships::plans.edit', compact('plan'));

    }

    /**
     * Opdaterer en eksisterende plan
     */
    public function update(Request $request, ...$args)
    {

        $plan = Plan::findOrFail($args[0]);

        $plan->update($request->validated());


        if ($request->filled('features')) {

            $plan->syncFeatures($request->features);

        }

        if ($request->filled('tags')) {

            $plan->syncTags($request->tags);

        }


        return redirect()
            ->route('memberships.plans.index')
            ->with('success', 'Planen er opdateret.');

    }



    /**
     * Slet plan (valgfrit)
     */
    public function destroy(Request $request, ...$args)
    {

        $plan = Plan::findOrFail($args[0]);

        $plan->delete();

        return redirect()
            ->route('memberships.plans.index')
            ->with('success', 'Planen er slettet.');

    }


}
