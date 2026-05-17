@extends('layouts.app')


@section('actions')

<a href="{{ route("memberships.subscriptions.create") }}" class="btn btn-primary">Opret medlemskab</a>

@endsection

@section('content')


<livewire:table 
    :config="Modules\Memberships\Tables\MembershipTable::class" 
/>


@endsection