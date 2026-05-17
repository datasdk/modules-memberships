<?php

namespace Modules\Memberships\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Memberships\Models\Subscription;

class SubscriptionRenewController extends Controller
{
    public function renew(Subscription $subscription)
    {
        // 🔹 Forny abonnement
        $subscription->renew(); // forudsætter du har en renew() metode på modellen

        // 🔹 Returnér view med succesbesked
        return view('subscription_renewed', [
            'subscription' => $subscription,
        ]);
    }
}
