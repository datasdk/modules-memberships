@extends('layouts.app')

@section('content')

{{-- Plan Info --}}
<table class="table table-bordered">
    <tr>
        <th width="150">Titel</th>
        <td>{{ $plan->title ?? '-' }}</td>
    </tr>
    <tr>
        <th width="150">Beskrivelse</th>
        <td>{{ $plan->description ?? '-' }}</td>
    </tr>
    <tr>
        <th width="150">Pris</th>
        <td>{{ $plan->price ?? '-' }} DKK</td>
    </tr>
    <tr>
        <th width="150">Aktiv</th>
        <td>{{ $plan->active ? 'Ja' : 'Nej' }}</td>
    </tr>
    <tr>
        <th width="150">Permanent medlemskab</th>
        <td>{{ $plan->permanent_membership ? 'Ja' : 'Nej' }}</td>
    </tr>
</table>

{{-- Abonnementsperiode --}}
<table class="table table-bordered">
    <tr>
        <th width="150">Faktureringsperiode</th>
        <td>{{ $plan->invoice_period ?? '-' }}</td>
    </tr>
    <tr>
        <th width="150">Faktureringsinterval</th>
        <td>{{ ucfirst($plan->invoice_interval) ?? '-' }}</td>
    </tr>
</table>

{{-- Prøveperiode --}}
@if(!$plan->permanent_membership)
<table class="table table-bordered">
    <tr>
        <th width="150">Gratis prøveperiode</th>
        <td>{{ $plan->has_trial ? 'Ja' : 'Nej' }}</td>
    </tr>
    @if($plan->has_trial)
    <tr>
        <th width="150">Varighed</th>
        <td>{{ $plan->trial_period ?? '-' }}</td>
    </tr>
    <tr>
        <th width="150">Interval</th>
        <td>{{ ucfirst($plan->trial_interval) ?? '-' }}</td>
    </tr>
    @endif
</table>
@endif

{{-- Grace-periode --}}
<table class="table table-bordered">
    <tr>
        <th width="150">Ophørstid efter udløb</th>
        <td>{{ $plan->grace_period ?? '-' }}</td>
    </tr>
    <tr>
        <th width="150">Interval</th>
        <td>{{ ucfirst($plan->grace_interval) ?? '-' }}</td>
    </tr>
</table>

{{-- Features --}}
<h4>Features</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Navn / Slug</th>
        </tr>
    </thead>
    <tbody>
        @forelse($plan->features as $feature)
        <tr>
            <td>{{ $feature->name ?? $feature->slug }}</td>
        </tr>
        @empty
        <tr>
            <td class="text-center"><i>Ingen features</i></td>
        </tr>
        @endforelse
    </tbody>
</table>

<a href="{{ route('memberships.plans.index') }}" class="btn btn-secondary mt-3">Tilbage</a>

@endsection
