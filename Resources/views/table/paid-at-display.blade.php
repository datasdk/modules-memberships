{{-- Modules/Memberships/Resources/views/table/paid-at-display.blade.php --}}

@php
    use Carbon\Carbon;

    $date = $paid_at ? Carbon::parse($paid_at) : null;
@endphp

<section class="whitespace-nowrap">
    @if($date)
        <span title="{{ $date->toDateTimeString() }}">
            {{ $date->format('d-m-Y H:i') }}
        </span>
    @else
        -
    @endif
</section>
