@extends('layouts.app')

@section('content')
<h3 class="mb-4">Membership Settings</h3>

<form method="POST" action="{{ route('memberships.settings.store') }}">
    @csrf

    <table class="table">
        <tbody>
   
            <tr>
                <td class="fw-bold" width="200">Auto-subscribe new users to plan</td>
                <td>
                    <select class="form-control" name="autoupgrade_plan_id">
                        <option value="">None</option>
                        @foreach(\Modules\Memberships\Models\Plan::all() as $plan)
                            <option value="{{ $plan->id }}" {{ $membershipSettings['autoupgrade_plan_id'] == $plan->id ? 'selected' : '' }}>
                                {{ $plan->title }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
</form>
@endsection
