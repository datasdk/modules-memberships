@extends('layouts.app')


@section('actions')

<a href="{{ route("memberships.plans.create") }}" class="btn btn-primary">Opret plan</a>

@endsection

@section('content')


<livewire:table 
    :config="Modules\Memberships\Tables\PlanTable::class" 
/>


@endsection