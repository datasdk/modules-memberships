@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('memberships.subscriptions.update', $subscription->id) }}">
    @csrf
    @method('PATCH')

    <div 
    x-data="{
        permanent: {{ old('permanent_membership') ?? $subscription->permanent_membership }},
        hasTrial: {{ old('has_trial') ?? $subscription->has_trial }},
   
        trialAutoUpgrade: {{ old('trial_auto_upgrade') ?? $subscription->trial_auto_upgrade }},
    }"
    >

        {{-- MEDLEMSKAB --}}
        <table class="table mb-4">
            <tr><th colspan="2">Medlemskab</th></tr>

            <tr>
                <td width="200">Abonnement</td>
                <td>
                    @livewire('memberships::select-plan', [
                        'value' => old('plan_id', $subscription->plan_id)
                    ], key('select-plan-edit-'.$subscription->id))
                </td>
            </tr>

            <tr>
                <td>Kunde</td>
                <td>
                    @livewire('select-user', [
                        'value' => $subscription->subscribable_id,
                        'disabled' => true
                    ], key('select-user-'.$subscription->id))
                </td>
            </tr>
        </table>




        {{-- ABONNEMENT PERIODE --}}
        <table class="table mb-4">
            <tr><th colspan="2">Abonnement periode</th></tr>

            <tr>
                <td width="200">Varighed</td>
                <td>

                    <div>
                        <label>
                            <input type="radio" name="permanent_membership" value="0" x-model="permanent">
                            <strong>Begrænset medlemskab</strong>
                            <p>
                                Opret medlemskab med opstarts- og slutdato.
                            </p>
                        </label>
                    </div>
                    
                    <div>
                        <label>
                            <input type="radio" name="permanent_membership" value="1" x-model="permanent">
                            <strong>Permanent medlemskab</strong>
                            <p>Giv kunden permanent adgang til medlemskabets fordele.</p>
                        </label>
                    </div>
                    
                </td>
            </tr>

            <tr>
                <td>Opstartsdato</td>
                <td>
                    <input type="date" name="starts_at" class="form-control"
                           value="{{ old('starts_at', $subscription->starts_at->format('Y-m-d')) }}">
                </td>
            </tr>

            <tr x-show="permanent == 0">
                <td>Slutdato</td>
                <td>
                    <input type="date" name="ends_at" class="form-control"
                           value="{{ old('ends_at', $subscription->ends_at->format('Y-m-d')) }}">
                </td>
            </tr>

            <tr x-show="permanent == 0">
                <td></td>
                <td>
                    <label>
                        <input type="checkbox" name="auto_renew" value="1" @if($subscription->auto_renew) checked @endif>
                        <strong>Automatisk fornyelse</strong>
                        <p>Forny medlemskabet automatisk efter endt periode.</p>
                    </label>
                </td>
            </tr>
        </table>




        {{-- PRØVEPERIODE --}}
        <table class="table mb-4" x-show="permanent == 0">
            <tr><th colspan="2">Gratis prøveperiode</th></tr>

            <tr>
                <td width="200">Valg</td>
                <td>

                    <div>
                       <label>
                            <input type="radio" name="has_trial" value="0" x-model="hasTrial">
                            <strong>Uden gratis prøveperiode</strong>
                            <p>Start medlemskabet uden prøveperiode.</p>
                        </label> 
                    </div>
                    
                    <div>
                        <label>
                            <input type="radio" name="has_trial" value="1" x-model="hasTrial">
                            <strong>Med gratis prøveperiode</strong>
                            <p>Kunden får fuld adgang indtil prøveperioden slutter.</p>
                        </label>
                    </div>
                    
                </td>
            </tr>

            <tr x-show="hasTrial == 1">
                <td>Slutdato (Prøveperiode)</td>
                <td>
                    <input type="date" name="trial_ends_at" class="form-control"
                        value="{{ old('trial_ends_at', optional($subscription->trial_ends_at)->format('Y-m-d')) }}">
                </td>
            </tr>

            <tr x-show="hasTrial == 1">
                <td></td>
                <td>
                    <label>
                        <input 
                            type="checkbox" name="trial_auto_upgrade" value="1" 
                            @if($subscription->trial_auto_upgrade) checked @endif
                        >
                        Opgrader automatisk til betalende medlemskab
                    </label>
                </td>
            </tr>
        </table>




        {{-- ORDREINDSTILLINGER --}}
        <table class="table mb-4">
            <tr><th colspan="2">Ordreindstillinger</th></tr>

            <tr>
                <td width="200">Betalingsmetode</td>
                <td>
                    @livewire('memberships::payment-method-select', [
                        'value' => old('payment_method', $subscription->payment_method)
                    ], key('payment-method-'.$subscription->id))
                </td>
            </tr>

            <tr>
                <td>Betalingsstatus</td>
                <td>
                    @livewire('memberships::payment-status-select', [
                        'value' => old('payment_status', $subscription->payment_status)
                    ], key('payment-status-'.$subscription->id))
                </td>
            </tr>

            <tr>
                <td>Betalingsdato</td>
                <td>
              
 
                    <input type="date" name="paid_at" class="form-control"
                           value="{{ old('paid_at') ?? optional($subscription->paid_at)->format('Y-m-d') }}">

                </td>
            </tr>
        </table>



        <button type="submit" class="btn btn-primary">Opdater abonnement</button>
        <a href="{{ route('memberships.subscriptions.index') }}" class="btn btn-secondary">Tilbage</a>

    </div>
</form>

@endsection
