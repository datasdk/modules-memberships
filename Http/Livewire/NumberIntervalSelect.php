<?php

namespace Modules\Memberships\Http\Livewire;

use Livewire\Component;


class NumberIntervalSelect extends Component
{

    public $period = 1;

    public $interval = '';

    public int $min = 1;

    public int $max = 100;

    public $numberName = 'number';

    public $intervalName = 'interval';


    public function mount(
        $period = 1,
        $interval = '',
        $min = 1,
        $max = 100,
        $numberName = 'number',
        $intervalName = 'interval'
    ) {

        
        $this->period = (int)$period;
        $this->interval = $interval;

        $this->min = $min;
        $this->max = $max;

        $this->numberName = $numberName;
        $this->intervalName = $intervalName;

    }


    public function updatedPeriod($value)
    {
        $this->emitUp('updatePeriod', $value);
    }


    public function updatedInterval($value)
    {
        $this->emitUp('updateInterval', $value);
    }


    public function getRangeProperty()
    {
        return range($this->min, $this->max);
    }


    public function render()
    {
        return view('memberships::livewire.number-interval-select');
    }


}
