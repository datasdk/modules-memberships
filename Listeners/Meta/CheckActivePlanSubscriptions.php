<?php

namespace Modules\Memberships\Listeners\Meta;

use Modules\Crm\Events\UserLoggedIn;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Modules\Memberships\Models\User as UserOrigin;


class CheckActivePlanSubscriptions
{

  
    public function handle(UserLoggedIn $event): void
    {

        
        $denyLoginWithoutPlan = false;


        $user = UserOrigin::findOrFail($event->user->id);


        // Tjek om metoden findes
        if (!method_exists($user, 'activePlanSubscriptions')) {

            $this->reject('User model mangler activePlanSubscriptions() metode.');

        }


        $activeCount = $user->activePlanSubscriptions()->count();


        if ($denyLoginWithoutPlan)
        if ($activeCount == 0 || !$user->isModerator()) {

            $this->reject('Brugeren har ingen aktive medlemskaber.');

        }

     
    }



    /**
     * Privat metode til at afvise login.
     */
    private function reject(string $reason): void
    {

        Log::warning('Login afvist: ' . $reason);

        throw new HttpException(401, $reason);

    }


}
