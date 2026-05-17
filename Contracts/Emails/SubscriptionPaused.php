<?php

namespace Modules\Memberships\Contracts\Emails;

use Modules\Email\Models\Email;
use Modules\Memberships\Models\Subscription;
use Modules\Email\Contracts\Abstract\EmailContract;;

class SubscriptionPaused extends EmailContract
{
    public function handle(Email $email): bool
    {
        return true;
    }
}
