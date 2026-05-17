<?php

namespace Modules\Memberships\Http\Livewire\Table;

use Livewire\Component;

class PaymentStatusChip extends Component
{
    public string $status;
    public string $paid_at;
    public string $color;


    public function mount(string $status, string $paid_at)
    {
        $this->status = $status;
        $this->paid_at = $paid_at;
        $this->color = $this->getChipColorProperty();

      
    }

    public function getTranslatedStatusProperty(): ?string
    {
        return match($this->status) {
            'pending' => 'Afventer',
            'paid'    => 'Betalt d. ' . $this->paid_at,
            'failed'  => 'Mislykket',
            'refunded'=> 'Refunderet',
            default   => $this->status,
        };
    }

    public function getChipColorProperty(): string
    {
        return match($this->status) {
            'pending' => 'orange',
            'paid'    => 'green',
            'failed'  => 'red',
            'refunded'=> 'blue',
            default   => 'grey',
        };
    }

    public function render()
    {
        return view('memberships::livewire.table.payment-status-chip');
    }
}
