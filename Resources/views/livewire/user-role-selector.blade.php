<section wire:init="loadMemberships">

    <table class="table">
        <tr>
            <th>Medlemskab</th>
        </tr>

        <tr>
            <td width="150"></td>

            <td>

                @if ($loading)
                    <div></div>
                @else

                    <div class="membership-overview pb-3">

                        @if (!count($memberships))
                            <div class="alert alert-info">
                                Der er ingen medlemskaber tilgængelige
                            </div>
                        @endif

                        @foreach ($memberships as $item)
                            <ul>
                                <li>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="memberships[]" {{-- Tilføjet name --}}
                                            wire:model="input"
                                            value="{{ $item['id'] }}"
                                        >
                                        <strong>{{ $item['title'] }}</strong>
                                    </label>

                                    <div class="id">id: {{ $item['id'] }}</div>
                                </li>
                            </ul>
                        @endforeach

                    </div>

                @endif

            </td>
        </tr>
    </table>

</section>

<style>
.membership-overview {
    overflow: auto;
    width: 100%;
    min-height: 100px;
    max-height: 300px;
    padding-top: 15px;
}
ul { list-style: none; padding: 0; margin: 0; }
ul li {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}
div.id {
    float: right;
    color: #ddd;
}
</style>
