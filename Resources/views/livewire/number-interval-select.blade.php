<div class="row">

    <!-- Talvælger -->
    <div class="col-4">
        
        <select name="{{ $numberName }}" class="form-control" wire:model="period" required>
            @foreach ($this->range as $number)
                <option value="{{ $number }}">{{ $number }}</option>
            @endforeach
        </select>

    </div>

 
    <!-- Intervalvælger -->
    <div class="col-8">

        <select name="{{ $intervalName }}" class="form-control" wire:model="interval" required>
            <option value="" disabled>Vælg interval</option>
            <option value="months">Måned</option>
            <option value="years">År</option>
            <option value="weeks">Uge</option>
            <option value="days">Dag</option>
        </select>

    </div>

</div>
