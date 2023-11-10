@extends('dashboard.layout.sidenav-layout')
@section('content')
    @include('dashboard.components.event.event-list')
    @include('dashboard.components.event.event-delete')
    @include('dashboard.components.event.event-create')
    @include('dashboard.components.event.event-update')
@endsection
