@extends('backend.layout.sidenav-layout')
@section('content')
    @include('backend.components.event.event-list')
    @include('backend.components.event.event-delete')
    @include('backend.components.event.event-create')
    @include('backend.components.event.event-update')
@endsection
