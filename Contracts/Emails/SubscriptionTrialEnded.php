<?php

namespace Modules\Memberships\Contracts\Emails;

use Modules\Email\Models\Email;
use Modules\Memberships\Models\Subscription;
use Carbon\Carbon;
use Modules\Email\Contracts\Abstract\EmailContract;;

class SubscriptionTrialEnded extends EmailContract
{
    public function handle(Email $email): bool
    {
        return true;
    }
}
