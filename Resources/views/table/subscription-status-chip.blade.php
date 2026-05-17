{{-- Modules/Memberships/Resources/views/table/subscription-status-chip.blade.php --}}

@php
    /** @var \Modules\Memberships\Models\Subscription $subscription */

    $map = [
        'active' => [
            'label' => 'Aktiv',
            'color' => '#16a34a', // grøn
        ],
        'on_trial' => [
            'label' => 'Prøveperiode',
            'color' => '#2563eb', // blå
        ],
        'on_grace' => [
            'label' => 'Graceperiode',
            'color' => '#f59e0b', // orange
        ],
        'canceled' => [
            'label' => 'Annulleret',
            'color' => '#dc2626', // rød
        ],
        'ended' => [
            'label' => 'Udløbet',
            'color' => '#6b7280', // grå
        ],
    ];

    $statusKey = $subscription->status ?? 'unknown';
    $chip = $map[$statusKey] ?? null;
@endphp

<section class="whitespace-nowrap">
    @if($chip)
        <span
            class="inline-block px-2 py-1 text-sm text-white rounded"
            style="background-color: {{ $chip['color'] }};"
        >
            {{ $chip['label'] }}
        </span>
    @else
        <span class="inline-block px-2 py-1 text-sm text-white rounded bg-gray-400">
            Ukendt
        </span>
    @endif
</section>
