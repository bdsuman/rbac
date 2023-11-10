@extends('dashboard.layout.sidenav-layout')
@section('content')
    @include('dashboard.components.role.list')
    @include('dashboard.components.role.delete')
    @include('dashboard.components.role.create')
    @include('dashboard.components.role.update')
@endsection
