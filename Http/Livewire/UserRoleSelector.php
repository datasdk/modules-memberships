<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;
use Modules\Memberships\Models\Plan;

class UserRoleSelector extends Component
{
    public array $value = [];     // initial prop fra parent
    public array $input = [];     // checkbox state
    public bool $loading = true;
    public $memberships = [];

    public function mount($value = [])
    {
        $this->value = $value ?? [];
        $this->input = $this->value;
    }

    public function updatedInput()
    {
        // svarer til this.$emit('input', this.input)
        $this->emitUp('membershipsUpdated', $this->input);
    }

    public function loadMemberships()
    {
        $this->loading = true;

        $this->memberships = Plan::query()
            ->orderBy('title')
            ->get()
            ->translate();

        $this->loading = false;
    }

    public function render()
    {
        return view('memberships::livewire.user-role-selector');
    }
}
