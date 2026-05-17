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
            // Plan & bruger
            'subscribable_id' => [
                'required',
                'exists:users,id',
            ],

            'plan_id' => [
                'required',
                'exists:memberships_plans,id',
                new NotOnPlan($this->subscribable_id),
            ],

            // Trial & billing
            'has_trial' => 'sometimes|boolean',
            'trial_period' => 'required_if_accepted:has_trial|integer|min:1',
            'trial_interval' => [
                'required_if_accepted:has_trial',
                Rule::in($this->intervals),
            ],

            'invoice_period' => 'required|integer|min:1',
            'invoice_interval' => [
                'required',
                Rule::in($this->intervals),
            ],

            // Dates
            'starts_at' => 'required|date',

            // Flags
            'active' => 'sometimes|boolean',
            'auto_upgrade' => 'sometimes|boolean',
            'permanent_membership' => 'sometimes|boolean',
            'new_user' => 'sometimes|boolean',

            // Payment
            'payment_method' => [
                'required',
                Rule::in($this->paymentMethods),
            ],
            'payment_status' => [
                'required',
                Rule::in(['pending', 'paid', 'failed', 'refunded']),
            ],
            // payment_status er string → required_if (IKKE accepted)
            'paid_at' => 'required_if:payment_status,paid|date',
            'customer' => 'sometimes|nullable|string|max:255',

            // User data (new user)
            'user.first_name' => 'required_if_accepted:new_user|string|max:255',
            'user.middle_name' => 'nullable|string|max:255',
            'user.last_name' => 'required_if_accepted:new_user|string|max:255',
            'user.email' => 'required_if_accepted:new_user|email|max:255',

            'user.contact.phone' => 'nullable|string|max:20',
            'user.invite' => 'sometimes|boolean',
            'user.password' => 'required_if_accepted:user.invite,false|string|min:6',
        ];
    }

    public function updateRules(): array
    {
        return [
            'subscribable_id' => 'sometimes|exists:users,id',

            'plan_id' => [
                'sometimes',
                'exists:memberships_plans,id',
            ],

            'has_trial' => 'sometimes|boolean',

            'trial_ends_at' => [
                'required_if_accepted:has_trial',
                'nullable',
                'date',
                function ($attribute, $value, $fail) {

                    if (!$this->boolean('has_trial')) {
                        return;
                    }

                    $startsAt            = $this->input('starts_at');
                    $endsAt              = $this->input('ends_at');
                    $permanentMembership = $this->boolean('permanent_membership');

                    if ($startsAt && strtotime($value) < strtotime($startsAt)) {
                        $fail('Prøveperiodens slutdato må ikke være før startdatoen.');
                    }

                    if (
                        !$permanentMembership &&
                        $endsAt &&
                        strtotime($value) > strtotime($endsAt)
                    ) {
                        $fail('Prøveperiodens slutdato må ikke være efter medlemskabets slutdato.');
                    }
                },
            ],

            'invoice_period' => 'sometimes|integer|min:1',
            'invoice_interval' => [
                'sometimes',
                Rule::in($this->intervals),
            ],

            'starts_at' => 'sometimes|nullable|date',
            'ends_at' => 'sometimes|nullable|date',

            'active' => 'sometimes|boolean',
            'auto_upgrade' => 'sometimes|boolean',
            'permanent_membership' => 'sometimes|boolean',
            'new_user' => 'sometimes|boolean',

            'payment_method' => [
                'sometimes',
                Rule::in($this->paymentMethods),
            ],
            'payment_status' => [
                'sometimes',
                Rule::in(['pending', 'paid', 'failed', 'refunded']),
            ],
            'paid_at' => 'required_if:payment_status,paid|date',
            'customer' => 'sometimes|nullable|string|max:255',

            // User (update)
            'user.first_name' => 'required_if_accepted:new_user|string|max:255',
            'user.middle_name' => 'nullable|string|max:255',
            'user.last_name' => 'required_if_accepted:new_user|string|max:255',
            'user.email' => 'required_if_accepted:new_user|email|max:255',

            'user.contact.phone' => 'nullable|string|max:20',
            'user.invite' => 'sometimes|boolean',
            'user.password' => 'required_if_accepted:user.invite,false|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            // Plan & bruger
            'subscribable_id.required' => 'En kunde skal vælges.',
            'subscribable_id.exists' => 'Den valgte kunde findes ikke.',

            'plan_id.required' => 'Abonnementsplan er påkrævet.',
            'plan_id.exists' => 'Den valgte plan findes ikke.',

            // Trial
            'has_trial.boolean' => 'Prøveperiode-valget skal være sand eller falsk.',
            'trial_period.required_if_accepted' => 'Prøveperiodens længde er påkrævet.',
            'trial_interval.required_if_accepted' => 'Prøveperiode-interval er påkrævet.',
            'trial_ends_at.required_if_accepted' => 'Prøveperiodens slutdato er påkrævet.',

            // Payment
            'paid_at.required_if' => "Betalingsdato er påkrævet, når status er 'betalt'.",

            // New user
            'user.first_name.required_if_accepted' => 'Fornavn er påkrævet for nye brugere.',
            'user.last_name.required_if_accepted' => 'Efternavn er påkrævet for nye brugere.',
            'user.email.required_if_accepted' => 'Email er påkrævet for nye brugere.',
            'user.password.required_if_accepted' => 'Adgangskode er påkrævet, når invitation ikke sendes.',
        ];
    }
}
