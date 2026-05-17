<?php

namespace Modules\Memberships\Http\Livewire\Table;

use Livewire\Component;

class PaidAtDisplay extends Component
{
    public $paid_at;

    public function mount($paid_at = null)
    {
        $this->paid_at = $paid_at;
    }

    public function render()
    {
        return view('memberships::livewire.table.paid-at-display');
    }
}
