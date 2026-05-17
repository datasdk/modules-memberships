<?php

namespace Modules\Memberships\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kun admin kan opdatere settings
        return true;
    }

    public function rules(): array
    {
        return [
            'autoupgrade_plan_id' => 'nullable|exists:memberships_plans,id',
        ];
    }

    public function messages(): array
    {
        return [
            'autoupgrade_plan_id.exists' => 'Vælg en gyldig plan.',
        ];
    }
}
