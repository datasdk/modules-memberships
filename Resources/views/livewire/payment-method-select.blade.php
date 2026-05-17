<div>
    <select name="payment_method" class="form-control" wire:model="value">
        <option value="" disabled>{{ $placeholder }}</option>

        @foreach($options as $opt)
            <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
        @endforeach
    </select>
</div>
