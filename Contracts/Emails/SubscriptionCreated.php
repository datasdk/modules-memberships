<?php

namespace Modules\Memberships\Contracts\Emails;

use Modules\Email\Models\Email;
use Modules\Email\Contracts\Abstract\EmailContract;;

class SubscriptionCreated extends EmailContract
{
    public function handle(Email $email): bool
    {
        return true;
    }
}
