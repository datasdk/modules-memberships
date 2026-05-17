<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;
use Modules\Memberships\Models\Membership;

class AssignMemberships extends Component
{
    public array $value = [];        // v-model for selected items
    public $model;                   // Parent model (f.eks. User, Role)
    public bool $open = false;
    public bool $loading = false;
    public $access = null;
    public array $memberships = [];
    public bool $sync = false;

    public function mount($value, $model)
    {
        $this->value = $value;
        $this->model = $model;

        $this->open = count($this->value) > 0;
        $this->memberships = Membership::all()->toArray();
    }

    public function submit()
    {
        $this->loading = true;

        $selectedIds = array_column($this->value, 'id');

        // Her kan du kalde en service, opdatere pivot-table eller relationer
        if ($this->sync) {
            $this->model->memberships()->sync($this->membershipsIds());
        } else {
            $this->model->memberships()->attach($this->membershipsIds());
        }

        $this->emitUp('submit');

        $this->open = false;
        $this->value = [];
        $this->emitUp('input', $this->value);

        $this->loading = false;
    }

    public function membershipsIds(): array
    {
        return array_filter((array)$this->memberships, function ($m) {
            return in_array($m['id'], (array)$this->memberships);
        });
    }

    public function render()
    {
        return view('memberships::livewire.assign-memberships');
    }
}
