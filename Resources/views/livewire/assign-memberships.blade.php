<div>
    @if($open)
        <div class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg w-1/2">
                <h3 class="text-lg font-bold mb-2">Medlemskaber</h3>
                <h4 class="text-sm mb-4">Tildel medlemskaber</h4>

                <div class="mb-4">
                    <label>Access</label>
                    <select name="access" class="form-control" wire:model="access">
                        <option value="">Vælg adgang</option>
                        <option value="full">Full</option>
                        <option value="limited">Begrænset</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>
                        <input type="checkbox" name="sync" wire:model="sync" class="mr-2" /> Synkroniser
                    </label>
                    <p class="text-xs text-gray-500 mt-1">
                        Vælger du synkroniser vil alle medlemskaber blive nulstille og erstattet med ovenstående valgte
                    </p>
                </div>

                <div class="mb-4">
                    <label>Medlemskaber</label>
                    <select name="memberships[]" class="form-control" wire:model="memberships" multiple>
                        @foreach($memberships as $m)
                            <option value="{{ $m['id'] }}">{{ $m['title'] ?? $m['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" class="btn btn-secondary" wire:click="$set('open', false)">Luk</button>
                    <button type="button" class="btn btn-primary" wire:click="submit" @if($loading) disabled @endif>
                        @if($loading) Tildeler... @else Tildel medlemskaber @endif
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
