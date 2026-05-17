<?php

namespace Modules\Memberships\Listeners\Meta;

use Modules\Crm\Events\Auth\UserAfterAuthenticated;

class SetUserHeaders
{
    /**
     * Handle the event.
     */
    public function handle(UserAfterAuthenticated $event): void
    {
        
        $user = $event->request->user();

        if ($user) {
            $event->response->headers->set('X-User-ID', $user->id);
            $event->response->headers->set('X-User-Email', $user->email);
        }


    }
}
