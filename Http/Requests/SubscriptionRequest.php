<?php

namespace Modules\Memberships\Http\Requests;

use Orion\Http\Requests\Request;
use Modules\Memberships\Rules\NotOnPlan;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends Request
{
    /**
     * Allowed payment methods
     */
    protected array $paymentMethods = [
        'credit_card',
        'paypal',
        'bank_transfer',
        'mobilepay',
        'cash',
        'other',
    ];

    /**
     * Allowed interval types
     */
    protected array $intervals = [
        'days',
        'weeks',
        'months',
        'years',
    ];


    public function storeRules(): array
    {
        return [
            "subscribable_id" => [
                "required",
                "exists:users,id"
            ],

            "plan_id" => [
                'required',
                'exists:memberships_plans,id',
                new NotOnPlan($this->subscribable_id ?? null)
            ],

            // Trial & billing
            "has_trial" => "sometimes|boolean",
            "trial_period" => "required_if:has_trial,true|integer|min:1",
            "trial_interval" => "required_if:has_trial,true|string|in:" . implode(',', $this->intervals),
            "invoice_period" => "required|integer|min:1",
            "invoice_interval" => "required|string|in:" . implode(',', $this->intervals),

            "auto_renew" => "sometimes",
            "trial_auto_upgrade" => "sometimes",

            // Dates
            "starts_at" => "required|date",

            // Flags & status
            "active" => "sometimes|boolean",
            "auto_upgrade" => "sometimes|boolean",
            "permanent_membership" => "sometimes|boolean",
            "new_user" => "sometimes|boolean",

            // Payment
            "payment_method" => "required|in:" . implode(',', $this->paymentMethods),
            "payment_status" => "required|in:pending,paid,failed,refunded",
            "paid_at" => "required_if:payment_status,paid|nullable|date",
            "customer" => "sometimes|nullable|string|max:255",

            // User data (new user)
            "user.first_name" => "required_if:new_user,1|string|max:255",
            "user.middle_name" => "nullable|string|max:255",
            "user.last_name" => "required_if:new_user,1|string|max:255",
            "user.email" => "required_if:new_user,1|email|max:255",
            "user.contact.phone" => "nullable|string|max:20",
            "user.invite" => "sometimes|boolean",
            "user.password" => "required_if:user.invite,false|nullable|string|min:6",
        ];
    }


    public function updateRules(): array
    {
        return [
            "subscribable_id" => "sometimes|exists:users,id",

            "plan_id" => [
                'sometimes',
                'exists:memberships_plans,id',
            ],

            "auto_renew" => "sometimes",
            "trial_auto_upgrade" => "sometimes",

            "has_trial" => "sometimes|boolean",
            "trial_ends_at" => [
                "required_if:has_trial,true",
                "nullable",
                "date",
                // Her tilføjes den vigtige validering:
                function ($attribute, $value, $fail) {

                    $has_trial                  = $this->boolean('has_trial');
                    $startsAt                   = $this->input('starts_at');
                    $endsAt                     = $this->input('ends_at');
                    $permanent_membership       = $this->boolean('permanent_membership');


                    
                    if($has_trial){

                        if ($startsAt && $value && strtotime($value) < strtotime($startsAt)) {
                            $fail("Prøveperiodens slutdato må ikke være før startdatoen.");
                        }

                        if(!$permanent_membership)
                        if ($endsAt && $value && strtotime($value) > strtotime($endsAt)) {
                            $fail("Prøveperiodens slutdato må ikke være efter medlemskabets slutdato.");
                        }

                    }

                }
            ],

            "invoice_period" => "sometimes|integer|min:1",
            "invoice_interval" => "sometimes|string|in:" . implode(',', $this->intervals),

            "starts_at" => "sometimes|nullable|date",
            "ends_at" => "sometimes|nullable|date",

            "active" => "sometimes|boolean",
            "auto_upgrade" => "sometimes|boolean",
            "permanent_membership" => "sometimes|boolean",
            "new_user" => "sometimes|boolean",

            "payment_method" => "sometimes|in:" . implode(',', $this->paymentMethods),
            "payment_status" => "sometimes|in:pending,paid,failed,refunded",
            "paid_at" => "required_if:payment_status,paid|nullable|date",
            "customer" => "sometimes|nullable|string|max:255",

            "user.first_name" => "required_if:new_user,1|string|max:255",
            "user.middle_name" => "nullable|string|max:255",
            "user.last_name" => "required_if:new_user,1|string|max:255",
            "user.email" => "required_if:new_user,1|email|max:255",
            "user.contact.phone" => "nullable|string|max:20",
            "user.invite" => "sometimes|boolean",
            "user.password" => "required_if:user.invite,false|nullable|string|min:6",
        ];
    }


    public function messages(): array
    {
        return [

            // Plan & bruger
            "subscribable_id.required" => "En kunde skal vælges.",
            "subscribable_id.exists" => "Den valgte kunde findes ikke.",

            "plan_id.required" => "Abonnementsplan er påkrævet.",
            "plan_id.exists" => "Den valgte plan findes ikke.",

            // Trial
            "has_trial.boolean" => "Prøveperiode-valget skal være sand eller falsk.",

            "trial_period.required_if" => "Prøveperiodens længde er påkrævet, når prøveperiode er aktiveret.",
            "trial_period.integer" => "Prøveperiodens længde skal være et tal.",
            "trial_period.min" => "Prøveperioden skal være mindst 1.",

            "trial_interval.required_if" => "Prøveperiode-interval er påkrævet, når prøveperiode er aktiveret.",
            "trial_interval.in" => "Prøveperiode-intervallet skal være enten days, weeks, months eller years.",

            "trial_ends_at.required_if" => "Prøveperiodens slutdato er påkrævet, når prøveperiode er aktiveret.",
            "trial_ends_at.date" => "Prøveperiodens slutdato skal være en gyldig dato.",

            // Subscription periode
            "invoice_period.required" => "Faktureringsperioden er påkrævet.",
            "invoice_period.integer" => "Faktureringsperioden skal være et tal.",
            "invoice_period.min" => "Faktureringsperioden skal være mindst 1.",

            "invoice_interval.required" => "Faktureringsinterval er påkrævet.",
            "invoice_interval.in" => "Faktureringsintervallet skal være enten days, weeks, months eller years.",

            // Dates
            "starts_at.required" => "Startdato er påkrævet.",
            "starts_at.date" => "Startdato skal være en gyldig dato.",

            "ends_at.date" => "Slutdato skal være en gyldig dato.",

            // Flags
            "active.boolean" => "Aktiv feltet skal være sand eller falsk.",
            "auto_upgrade.boolean" => "Auto-opgradering skal være sand eller falsk.",
            "auto_renew.boolean" => "Automatisk fornyelse skal være sand eller falsk.",
            "permanent_membership.boolean" => "Permanent medlemskab skal være sand eller falsk.",
            "new_user.boolean" => "Ny bruger-valget skal være sand eller falsk.",

            // Payment
            "payment_method.required" => "Betalingsmetode er påkrævet.",
            "payment_method.in" => "Den valgte betalingsmetode er ugyldig.",

            "payment_status.required" => "Betalingsstatus er påkrævet.",
            "payment_status.in" => "Den valgte betalingsstatus er ugyldig.",

            "paid_at.required_if" => "Betalingsdato er påkrævet, når status er 'betalt'.",
            "paid_at.date" => "Betalingsdato skal være en gyldig dato.",

            "customer.string" => "Kunde-navnet skal være en tekststreng.",
            "customer.max" => "Kunde-navnet må højst være på 255 tegn.",

            // New user
            "user.first_name.required_if" => "Fornavn er påkrævet for nye brugere.",
            "user.first_name.string" => "Fornavn skal være tekst.",
            "user.first_name.max" => "Fornavn må højst indeholde 255 tegn.",

            "user.middle_name.string" => "Mellemnavn skal være tekst.",
            "user.middle_name.max" => "Mellemnavn må højst indeholde 255 tegn.",

            "user.last_name.required_if" => "Efternavn er påkrævet for nye brugere.",
            "user.last_name.string" => "Efternavn skal være tekst.",
            "user.last_name.max" => "Efternavn må højst indeholde 255 tegn.",

            "user.email.required_if" => "Email er påkrævet for nye brugere.",
            "user.email.email" => "Email skal være gyldig.",
            "user.email.max" => "Email må højst indeholde 255 tegn.",

            "user.contact.phone.string" => "Telefonnummer skal være en tekststreng.",
            "user.contact.phone.max" => "Telefonnummer må højst indeholde 20 tegn.",

            "user.invite.boolean" => "Invite-værdien skal være sand eller falsk.",

            "user.password.required_if" => "Adgangskode er påkrævet, når invitation ikke sendes.",
            "user.password.min" => "Adgangskoden skal være på mindst 6 tegn.",
            "user.password.string" => "Adgangskoden skal være tekst.",
        ];
    }

}
