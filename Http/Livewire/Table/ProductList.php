<?php

namespace Modules\Memberships\Http\Livewire\Table;

use Livewire\Component;

class ProductList extends Component
{
    public array $items = [];

    public function mount(array $items = [])
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('memberships::livewire.table.product-list');
    }
}
