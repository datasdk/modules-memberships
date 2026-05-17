<?php

namespace Modules\Memberships\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Rokde\SubscriptionManager\Insights\Customer;


class SubscriptionCustomers extends Controller
{

  // Metode til at hente subscription-historik
    public function index(Request $request)
    {
        
        // Hent subscription-historik (justér efter behov)
        $history = new Customer();

        $histogram = $history->get();  // Hent historikken som en keyed-map

        // Returnér historikken som JSON-respons
        return response()->json($histogram);

    }

    // Metode til at vise detaljer om et bestemt element i subscription-historikken
    public function Customerow($id)
    {
        // Find subscription-historikken baseret på ID
        $history = Customer::findOrFail($id);

        // Returnér historikken som JSON-respons
        return response()->json($history);
    }

    // Metode til at oprette ny subscription-historik
    public function store(Request $request)
    {
        // Validér de indsendte data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'started_at' => 'required|date',
            'ended_at' => 'required|date',
        ]);

        // Opret en ny subscription-historik
        $history = Customer::create($validated);

        // Returnér den oprettede historik som JSON-respons
        return response()->json($history, 201);
    }

    // Metode til at opdatere en eksisterende subscription-historik
    public function update(Request $request, ...$args)
    {
        // Find den eksisterende subscription-historik
        $history = Customer::findOrFail($id);

        // Validér de indsendte data
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'plan_id' => 'sometimes|exists:plans,id',
            'started_at' => 'sometimes|date',
            'ended_at' => 'sometimes|date',
        ]);

        // Opdater subscription-historikken
        $history->update($validated);

        // Returnér den opdaterede historik som JSON-respons
        return response()->json($history);
    }

    // Metode til at slette en subscription-historik
    public function destroy($id)
    {
        // Find og slet subscription-historikken
        $history = Customer::findOrFail($id);
        $history->delete();

        // Returnér en succesbesked
        return response()->json(['message' => 'Subscription history deleted successfully']);
    }
}
