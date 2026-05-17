@extends('layouts.app')

@section('content')

<h1>Abonnement #{{ $subscription->id }}</h1>

{{-- MEDLEMSKAB --}}
<table class="table table-bordered">
    <tr><th colspan="2">Medlemskab</th></tr>
    <tr>
        <th width="200">Bruger / Firma</th>
        <td>
            @if($subscription->subscribable)
                {{ $subscription->subscribable->name ?? $subscription->subscribable->email ?? 'ID: '.$subscription->subscribable->id }}
            @else
                <em>Ingen</em>
            @endif
        </td>
    </tr>
    <tr>
        <th>Plan</th>
        <td>
    
            {{ $subscription->plan?->name ?? '<em>Ingen plan</em>' }}
        </td>
    </tr>
    <tr>
        <th>Beskrivelse</th>
        <td>{{ $subscription->description ?? '-' }}</td>
    </tr>
</table>

{{-- ABONNEMENTS PERIODE --}}
<table class="table table-bordered">
    <tr><th colspan="2">Abonnementsperiode</th></tr>
    <tr>
        <th width="200">Startdato</th>
        <td>{{ $subscription->starts_at?->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <th>Slutdato</th>
        <td>{{ $subscription->ends_at?->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <th>Permanent medlemskab</th>
        <td>{{ $subscription->permanent_membership ? 'Ja' : 'Nej' }}</td>
    </tr>
    <tr>
        <th>Trial slut</th>
        <td>{{ $subscription->trial_ends_at?->format('d-m-Y') ?? 'Ingen prøveperiode' }}</td>
    </tr>
    <tr>
        <th>Automatisk fornyelse</th>
        <td>{{ $subscription->auto_renew ? 'Ja' : 'Nej' }}</td>
    </tr>
    <tr>
        <th>Trial auto-opgradering</th>
        <td>{{ $subscription->trial_auto_upgrade ? 'Ja' : 'Nej' }}</td>
    </tr>
</table>

{{-- ORDREINDSTILLINGER --}}
<table class="table table-bordered">
    <tr><th colspan="2">Ordreindstillinger</th></tr>
    <tr>
        <th width="200">Betalingsmetode</th>
        <td>
            @include('memberships::table.payment-method-display', [
                'method' => $subscription->payment_method
            ])
        </td>
    </tr>
    <tr>
        <th>Betalingsstatus</th>
        <td>
            @include('memberships::table.subscription-status-chip', [
                'status' => $subscription->status,
                'paid_at' => $subscription->paid_at
            ])
        </td>
    </tr>
    <tr>
        <th>Betalingsdato</th>
        <td>
            @include('memberships::table.paid-at-display', [
                'paid_at' => $subscription->paid_at
            ])
        </td>
    </tr>
</table>

{{-- LOG / OVERSIGT --}}
<table class="table table-bordered">
    <tr><th colspan="2">Oversigt</th></tr>
    <tr>
        <th width="200">Oprettet</th>
        <td>{{ $subscription->created_at?->format('d-m-Y H:i') }}</td>
    </tr>
    <tr>
        <th>Opdateret</th>
        <td>{{ $subscription->updated_at?->format('d-m-Y H:i') }}</td>
    </tr>
    <tr>
        <th>Annuleret</th>
        <td>{{ $subscription->canceled_at?->format('d-m-Y H:i') ?? 'Nej' }}</td>
    </tr>
</table>

<a href="{{ route('memberships.subscriptions.index') }}" class="btn btn-secondary mt-3">Tilbage</a>

@endsection
