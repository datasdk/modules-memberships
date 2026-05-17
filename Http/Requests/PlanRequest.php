<?php

namespace Modules\Memberships\Http\Requests;

use Orion\Http\Requests\Request;

class PlanRequest extends Request
{
    /**
     * Tilladte intervaltyper
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
            "title" => "required|max:255",
            "description" => "sometimes|nullable|max:1000",
            "features" => "sometimes|array",
            "features.*" => "required_with:features|string",
            "sku" => "sometimes|string",
            "price" => "required|numeric|min:0",
            "tags" => "sometimes|array",
            "tags.*" => "required_with:tags|string",
            "active" => "sometimes|boolean",

            // Fakturering
            "invoice_period" => "required|integer|min:1",
            "invoice_interval" => "required|string|in:" . implode(',', $this->intervals),
            "grace_period" => "required|integer|min:0",
            "grace_interval" => "required|string|in:" . implode(',', $this->intervals),

            // Prøveperiode & medlemskab
            "has_trial" => [
                "sometimes",
                "boolean",
            ],
            "trial_period" => "required_if:has_trial,true|integer|min:1",
            "trial_interval" => "required_if:has_trial,true|string|in:" . implode(',', $this->intervals),
            "trial_auto_upgrade" => "sometimes|boolean",
            "auto_upgrade" => "sometimes|boolean",
            "permanent_membership" => "sometimes|boolean",
        ];
    }


    public function updateRules(): array
    {

      

        return [
            "title" => "required|max:255",
            "description" => "sometimes|nullable|max:1000",
            "features" => "sometimes|array",
            "features.*" => "required_with:features|string",
            "sku" => "sometimes|string",
            "price" => "required|numeric|min:0",
            "tags" => "sometimes|array",
            "tags.*" => "required_with:tags|string",
            "active" => "sometimes|boolean",

            // Fakturering
            "invoice_period" => "required|integer|min:1",
            "invoice_interval" => "required|string|in:" . implode(',', $this->intervals),
            "grace_period" => "required|integer|min:0",
            "grace_interval" => "required|string|in:" . implode(',', $this->intervals),

            // Prøveperiode & medlemskab
            "has_trial" => [
                "sometimes",
                "boolean",

            ],
            "trial_period" => "required_if:has_trial,true|integer|min:1",
            "trial_interval" => "required_if:has_trial,true|string|in:" . implode(',', $this->intervals),
            "trial_auto_upgrade" => "sometimes|boolean",
            "auto_upgrade" => "sometimes|boolean",
            "permanent_membership" => "sometimes|boolean",
        ];

    }


    public function messages(): array
    {
        return [
            'title.required' => 'Titel er påkrævet.',
            'price.required' => 'Pris er påkrævet.',
            'price.numeric' => 'Pris skal være et tal.',
            'price.min' => 'Pris skal være mindst 0.',
            'features.array' => 'Features skal være et array.',
            'features.*.required_with' => 'Hver feature skal være en gyldig værdi.',
            'features.*.string' => 'Hver feature skal være en tekststreng.',
            'sku.string' => 'SKU skal være en tekststreng.',
            'tags.array' => 'Tags skal være et array.',
            'tags.*.required_with' => 'Hver tag skal være en gyldig værdi.',
            'tags.*.string' => 'Hver tag skal være en tekststreng.',

            'invoice_period.required' => 'Faktureringsperiode er påkrævet.',
            'invoice_period.integer' => 'Faktureringsperiode skal være et tal.',
            'invoice_period.min' => 'Faktureringsperiode skal være mindst 1.',

            'invoice_interval.required' => 'Faktureringsinterval er påkrævet.',
            'invoice_interval.in' => 'Faktureringsinterval skal være en af: days, weeks, months, years.',

            'grace_period.required' => 'Grace-periode er påkrævet.',
            'grace_period.integer' => 'Grace-periode skal være et tal.',
            'grace_period.min' => 'Grace-periode skal være mindst 0.',

            'grace_interval.required' => 'Grace-interval er påkrævet.',
            'grace_interval.in' => 'Grace-interval skal være en af: days, weeks, months, years.',

            'has_trial.boolean' => 'Has_trial skal være sand eller falsk.',
            'has_trial.prohibited_if' => 'Gratis prøveperiode kan ikke aktiveres, når medlemskabet er permanent.',

            'trial_period.required_if' => 'Prøveperiode er påkrævet, når gratis prøveperiode er aktiveret.',
            'trial_period.integer' => 'Prøveperiode skal være et tal.',
            'trial_period.min' => 'Prøveperiode skal være mindst 1.',
            'trial_interval.required_if' => 'Prøveinterval er påkrævet, når gratis prøveperiode er aktiveret.',
            'trial_interval.in' => 'Prøveinterval skal være en af: days, weeks, months, years.',
            'trial_auto_upgrade.boolean' => 'Trial_auto_upgrade skal være sand eller falsk.',

            'auto_upgrade.boolean' => 'Auto_upgrade skal være sand eller falsk.',
            'permanent_membership.boolean' => 'Permanent_membership skal være sand eller falsk.',
        ];
    }

}
