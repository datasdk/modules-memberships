<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;
use Modules\Memberships\Models\Plan;

class SelectPlan extends Component
{
    public $value = null;      // v-model fra parent
    public $selected = null;   // internt valgt plan-id
    public $plans = [];
    public $loading = true;

    public function mount($value = null)
    {
        $this->value = $value;
        $this->selected = $value;
        $this->loadPlans();
    }

    public function updatedSelected($planId)
    {
        $this->emitUp('input', $planId);

        $plan = collect($this->plans)->firstWhere('id', $planId);
        $this->emitUp('change', $plan);
    }

    public function loadPlans()
    {
        $this->loading = true;

        $this->plans = Plan::all()->translate();

        $this->loading = false;

        $this->emitUp('loaded', $this->plans);
    }

    public function getPlanLabel($item): string
    {

    
        $label = "{$item['title']} - {$item['price']} DKK - {$item['invoice_period']} x {$item['invoice_interval']}";
        if (!empty($item['sku'])) {
            $label .= " - sku: {$item['sku']}";
        }
        return $label;
    }

    public function render()
    {
        return view('memberships::livewire.select-plan');
    }
}
