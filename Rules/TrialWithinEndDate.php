<?php

namespace Modules\Memberships\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class TrialWithinEndDate implements Rule
{
    protected $startsAt;
    protected $endsAt;
    protected $interval;
    protected $period;

    public function __construct($startsAt, $endsAt, $period, $interval)
    {
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->period = $period;
        $this->interval = $interval;
    }

    public function passes($attribute, $value)
    {
        if (!$this->startsAt || !$this->endsAt || !$this->period || !$this->interval) {
            return true; // Ikke nok data til at validere
        }

        $start = Carbon::parse($this->startsAt);
        $end = Carbon::parse($this->endsAt);

        // Map plural units til singular for Carbon
        $unitMap = [
            'days' => 'day',
            'weeks' => 'week',
            'months' => 'month',
            'years' => 'year'
        ];

        $unit = $unitMap[$this->interval] ?? 'day';

        $trialEnd = $start->copy()->add($this->period, $unit);

        return $trialEnd->lte($end);
    }

    public function message()
    {
        return 'Prøveperioden kan ikke overstige slutdatoen for medlemskabet.';
    }
}
