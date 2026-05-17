<div>
    @if($loading)
        <div></div>
    @elseif(!count($plans))
        <div><strong>Ingen planer fundet</strong></div>
        <div>
            Der blev ikke fundet nogen medlemskaber<br />
            <a href="{{ route('memberships.plans.create') }}">Klik her</a> for at oprette en ny plan
        </div>
    @else
        <select name="{{ $name ?? 'plan_id' }}" class="form-control" wire:model="selected">
            <option value="" disabled>Vælg abonnement</option>
            @foreach($plans as $item)
                <option value="{{ $item['id'] }}">
                    {{ $this->getPlanLabel($item) }}
                </option>
            @endforeach
        </select>
    @endif
</div>
