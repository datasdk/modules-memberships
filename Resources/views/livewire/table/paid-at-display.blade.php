<section>
    @if($paid_at)
        <span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
            {{ $paid_at }}
        </span>
    @else
        <span class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded">
            Ikke betalt
        </span>
    @endif
</section>
