<?php

namespace Modules\Memberships\Http\Livewire\Table;

use Livewire\Component;

class SubscriptionStatusChip extends Component
{
    public string $status = 'unknown';
    public string $color;

    public function mount(string $status = 'unknown')
    {
        $this->status = $status;
        $this->color = $this->getColorProperty();
    }

    public function getColorProperty(): string
    {
        return match($this->status) {
            'active'    => 'green',
            'on_trial'  => 'blue',
            'on_grace'  => 'orange',
            'canceled'  => 'red',
            'ended'     => 'grey',
            default     => 'grey lighten-1',
        };
    }

    public function getLabelProperty(): string
    {
        return match($this->status) {
            'active'    => 'Aktiv',
            'on_trial'  => 'Prøveperiode',
            'on_grace'  => 'Graceperiode',
            'canceled'  => 'Annulleret',
            'ended'     => 'Udløbet',
            default     => 'Ukendt',
        };
    }

    public function render()
    {
        return view('memberships::livewire.table.subscription-status-chip');
    }
}
