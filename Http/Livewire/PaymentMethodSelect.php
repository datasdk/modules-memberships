<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;

class PaymentMethodSelect extends Component
{
    public string $value = '';
    public string $placeholder = 'Vælg metode';

    public array $options = [
        ['value' => 'credit_card', 'label' => 'Betalingskort'],
        ['value' => 'bank_transfer', 'label' => 'Bankoverførsel'],
        ['value' => 'mobilepay', 'label' => 'MobilePay'],
        ['value' => 'iap', 'label' => 'In App Purchase'],
        ['value' => 'cash', 'label' => 'Kontant'],
        ['value' => 'other', 'label' => 'Andet'],
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
        $this->emitUp('paymentMethodUpdated', $val);
    }

    public function render()
    {
        return view('memberships::livewire.payment-method-select');
    }
}
