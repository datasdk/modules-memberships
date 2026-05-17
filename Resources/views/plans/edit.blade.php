@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('memberships.plans.update', $plan->id) }}">
    @csrf
    @method('PATCH')

    <div x-data="{
        permanent: {{ old('permanent_membership', $plan->permanent_membership ?? 0) }},
        hasTrial: {{ old('has_trial', $plan->has_trial ?? 0) }}
    }">

        {{-- PLAN --}}
        <table class="table">
            <tr><th colspan="2">Plan</th></tr>

            <tr>
                <td width="200">Titel</td>
                <td>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $plan->title ?? '') }}" required>
                </td>
            </tr>

            <tr>
                <td>Indhold</td>
                <td>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description', $plan->description ?? '') }}</textarea>
                </td>
            </tr>

            <tr>
                <td>Aktiv</td>
                <td>
                    <label>
                        <input type="checkbox" name="active" value="1" {{ old('active', $plan->active ?? 1) ? 'checked' : '' }}>
                        Medlemskabsplanen er aktiv
                    </label>
                </td>
            </tr>
        </table>

        {{-- PRIS --}}
        <table class="table">
            <tr><th colspan="2">Pris</th></tr>
            <tr>
                <td width="200">Pris (DKK)</td>
                <td>
                    <input type="number" name="price" class="form-control" min="0" step="0.01"
                        value="{{ old('price', $plan->price ?? 0) }}" required>
                </td>
            </tr>
        </table>

        {{-- ABONNEMENTS PERIODE --}}
        <table class="table">
            <tr><th colspan="2">Abonnementsperiode</th></tr>

            <tr>
                <td width="200">Varighed</td>
                <td>

                    <div>
                         <label>
                            <input type="radio" name="permanent_membership" value="0" x-model="permanent">
                            <strong>Begrænset medlemskab</strong>
                            <p>Opret medlemskab med opstarts- og udløbsdato.</p>
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

            <tr x-show="permanent == 0">
                <td>Faktureringsperiode</td>
                <td>
                    <input type="number" name="invoice_period" class="form-control" min="1"
                        value="{{ old('invoice_period', $plan->invoice_period ?? 1) }}" required>
                </td>
            </tr>

            <tr x-show="permanent == 0">
                <td>Faktureringsinterval</td>
                <td>
                    <select name="invoice_interval" class="form-control" required>
                        <option value="days" {{ old('invoice_interval', $plan->invoice_interval ?? '') == 'days' ? 'selected' : '' }}>Dag(e)</option>
                        <option value="weeks" {{ old('invoice_interval', $plan->invoice_interval ?? '') == 'weeks' ? 'selected' : '' }}>Uge(r)</option>
                        <option value="months" {{ old('invoice_interval', $plan->invoice_interval ?? '') == 'months' ? 'selected' : '' }}>Måned(er)</option>
                        <option value="years" {{ old('invoice_interval', $plan->invoice_interval ?? '') == 'years' ? 'selected' : '' }}>År</option>
                    </select>
                </td>
            </tr>
        </table>

        {{-- PRØVEPERIODE --}}
        <table class="table" x-show="permanent == 0">
            <tr><th colspan="2">Prøve-periode</th></tr>

            <tr>
                <td width="200">Gratis prøveperiode</td>
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
                    <input type="number" name="trial_period" class="form-control" min="1"
                        value="{{ old('trial_period', $plan->trial_period ?? 7) }}" required>
                </td>
            </tr>

            <tr x-show="hasTrial == 1">
                <td>Interval</td>
                <td>
                    <select name="trial_interval" class="form-control" required>
                        <option value="days" {{ old('trial_interval', $plan->trial_interval ?? '') == 'days' ? 'selected' : '' }}>Dag(e)</option>
                        <option value="weeks" {{ old('trial_interval', $plan->trial_interval ?? '') == 'weeks' ? 'selected' : '' }}>Uge(r)</option>
                        <option value="months" {{ old('trial_interval', $plan->trial_interval ?? '') == 'months' ? 'selected' : '' }}>Måned(er)</option>
                    </select>
                </td>
            </tr>
        </table>

        {{-- GRACE-PERIODE --}}
        <table class="table">
            <tr><th colspan="2">Grace-periode</th></tr>

            <tr>
                <td width="200">Ophørstid efter udløb</td>
                <td>
                    <input type="number" name="grace_period" class="form-control" min="0"
                        value="{{ old('grace_period', $plan->grace_period ?? 7) }}" required>
                </td>
            </tr>

            <tr>
                <td>Interval</td>
                <td>
                    <select name="grace_interval" class="form-control" required>
                        <option value="days" {{ old('grace_interval', $plan->grace_interval ?? '') == 'days' ? 'selected' : '' }}>Dag(e)</option>
                        <option value="weeks" {{ old('grace_interval', $plan->grace_interval ?? '') == 'weeks' ? 'selected' : '' }}>Uge(r)</option>
                        <option value="months" {{ old('grace_interval', $plan->grace_interval ?? '') == 'months' ? 'selected' : '' }}>Måned(er)</option>
                    </select>
                </td>
            </tr>
        </table>

        {{-- HANDLINGER --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Opdater Plan</button>
            <a href="{{ route('memberships.plans.index') }}" class="btn btn-secondary">Tilbage</a>
        </div>

    </div>
</form>
@endsection
