@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('memberships.subscriptions.store') }}">

    @csrf


    <div x-data="{
        permanent: {{ old('permanent_membership', 0) }},
        hasTrial: {{ old('has_trial', 0) }}
    }">

        {{-- MEDLEMSKAB --}}
        <table class="table">

            <tr><th colspan="2">Medlemskab</th></tr>

            <tr>
                <td width="200">Abonnement</td>
                <td>

                    @livewire('memberships::select-plan', ['value' => old('plan_id')], key('select-plan-create'))

                </td>
            </tr>

            <tr>
                <td>Kunde</td>
                <td>

                    @livewire('select-user', [
                        'value' => old('subscribable_id'),
                        'disabled' => false,
                        'name' => 'subscribable_id'
                    ], key('select-user-create'))

                </td>
            </tr>
        </table>

        {{-- ABONNEMENT PERIODE --}}
        <table class="table">
            <tr><th colspan="2">Abonnementsperiode</th></tr>

            <tr>
                <td width="200">Varighed</td>
                <td>
                    <label>
                        <input type="radio" name="permanent_membership" value="0" x-model="permanent"> 
                        <strong>Begrænset medlemskab</strong>
                        <p>Opret medlemskab med opstarts- og udløbsdato. Brugeren kan ikke tilgå fordelene efter endt periode.</p>
                    </label>
                    <label>
                        <input type="radio" name="permanent_membership" value="1" x-model="permanent"> 
                        <strong>Permanent medlemskab</strong>
                        <p>Giv kunden permanent adgang til medlemskabets fordele.</p>
                    </label>
                </td>
            </tr>

            <tr x-show="permanent == 0">
                <td>Opstartsdato</td>
                <td>
                    <input type="date" name="starts_at" class="form-control" value="{{ old('starts_at') ?? date('Y-m-d') }}">
                </td>
            </tr>

            <tr x-show="permanent == 0">

                <td>Varighed</td>
                <td>

                    @livewire('memberships::number-interval-select', [
                        'period' => old('invoice_period', 1),
                        'interval' => old('invoice_interval', 'month'),
                        'min' => 1,
                        'max' => 100,
                        'numberName' => 'invoice_period',
                        'intervalName' => 'invoice_interval'
                    ], key('invoice-number-interval-select-create'))

                </td>
            </tr>

            <tr>
                <td></td>
                <td>

                    <label>
                        
                        <input type="checkbox" name="auto_renew" checked value="1" {{ old('auto_renew') ? 'checked' : '' }}> Automatisk fornyelse
                    
                    </label>

                </td>
            </tr>
        </table>


        {{-- PRØVEPERIODE --}}
        <table class="table" x-show="permanent == 0">

            <tr><th colspan="2">Gratis prøveperiode</th></tr>

            <tr>
                <td width="200">Valg</td>
                <td>
                    <div>
                        <label>
                            <input type="radio" name="has_trial" value="0" x-model="hasTrial"> 
                            <strong>Uden gratis prøveperiode</strong>
                            <div>Start abonnement med det sammme uden prøveperiode</div>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="has_trial" value="1" x-model="hasTrial">
                            <strong>Med gratis prøveperiode</strong>
                            <div>Tidsbegrænset prøveperiode, med mulighed for fornyelse herefter</div>
                        </label>
                    </div>
                </td>
            </tr>

            <tr x-show="hasTrial == 1">
                <td>Varighed</td>
                <td>
                    @livewire('memberships::number-interval-select', [
                        'period' => old('trial_period', 7),
                        'interval' => old('trial_interval', 'day'),
                        'min' => 1,
                        'max' => 100,
                        'numberName' => 'trial_period',
                        'intervalName' => 'trial_interval'
                    ], key('trial-number-interval-select-create'))
                </td>
            </tr>

            <tr x-show="hasTrial == 1">
                <td></td>
                <td>
                    <label>
                        <input type="checkbox" name="trial_auto_upgrade" value="1" {{ old('trial_auto_upgrade') ? 'checked' : '' }}> Opgrader automatisk til betalende medlemskab
                    </label>
                </td>
            </tr>
        </table>

        {{-- ORDREINDSTILLINGER --}}
        <table class="table">
            <tr><th colspan="2">Ordreindstillinger</th></tr>

            <tr>
                <td width="200">Betalingsmetode</td>
                <td>
                    @livewire('memberships::payment-method-select', ['value' => old('payment_method', 'card')], key('payment-method-select-create'))
                </td>
            </tr>

            <tr>
                <td>Betalingsstatus</td>
                <td>
                    @livewire('memberships::payment-status-select', ['value' => old('payment_status', 'pending')], key('payment-status-select-create'))
                </td>
            </tr>

            <tr>
                <td>Betalingsdato</td>
                <td>
                    @livewire('memberships::paid-at-display', ['value' => old('paid_at', date('Y-m-d'))], key('paid-at-display-create'))
                </td>
            </tr>
        </table>


        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Opret abonnement</button>
            <a href="{{ route('memberships.subscriptions.index') }}" class="btn btn-secondary">Tilbage</a>
        </div>

    </div>
</form>

@endsection
