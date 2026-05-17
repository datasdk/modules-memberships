{{-- Modules/Memberships/Resources/views/table/payment-method-display.blade.php --}}

@php
    $map = [
        'credit_card' => [
            'label' => 'Betalingskort',
            'icon'  => 'mdi-credit-card-outline',
        ],
        'paypal' => [
            'label' => 'PayPal',
            'icon'  => 'mdi-paypal',
        ],
        'cash' => [
            'label' => 'Kontant',
            'icon'  => 'mdi-cash',
        ],
    ];

    $methodKey = $method ?? null;
    $item = $map[$methodKey] ?? null;
@endphp

<section class="flex items-center gap-2">
    @if($item)
        <i class="mdi {{ $item['icon'] }} text-lg"></i>
        <span>{{ $item['label'] }}</span>
    @elseif($method)
        <i class="mdi mdi-help-circle-outline text-lg text-gray-400"></i>
        <span>{{ $method }}</span>
    @else
        -
    @endif
</section>
