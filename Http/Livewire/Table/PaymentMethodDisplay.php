<?php

namespace Modules\Memberships\Http\Livewire\Table;

use Livewire\Component;

class PaymentMethodDisplay extends Component
{
    public $method;
    public $icon;

    public function mount($method)
    {
        $this->method = $method;
        $this->icon = $this->getIconProperty();
        
    }

    public function getTranslatedMethodProperty()
    {
        return match ($this->method) {
            'credit_card' => 'Betalingskort',
            'paypal'      => 'PayPal',
            'cash'        => 'Kontant',
            default       => $this->method,
        };
    }

    public function getIconProperty()
    {
        return match ($this->method) {
            'credit_card' => 'mdi-credit-card-outline',
            'paypal'      => 'mdi-paypal',
            'cash'        => 'mdi-cash',
            default       => 'mdi-help-circle-outline',
        };
    }

    public function render()
    {
        return view('memberships::livewire.table.payment-method-display');
    }
}
