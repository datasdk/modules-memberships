<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;

class PaymentStatusSelect extends Component
{
    public string $value = '';
    public string $placeholder = 'Vælg status';

    public array $options = [
        ['value' => 'paid', 'label' => 'Betalt'],
        ['value' => 'pending', 'label' => 'Afventer betaling'],
        ['value' => 'failed', 'label' => 'Betaling fejlet'],
        ['value' => 'refunded', 'label' => 'Refunderet'],
    ];

    public function mount($value = '', $placeholder = null)
    {
        $this->value = $value;

        if ($placeholder !== null) {
            $this->placeholder = $placeholder;
        }
    }

    public function updatedValue($val)
    {
        $this->emitUp('paymentStatusUpdated', $val);
    }

    public function render()
    {
        return view('memberships::livewire.payment-status-select');
    }
}
