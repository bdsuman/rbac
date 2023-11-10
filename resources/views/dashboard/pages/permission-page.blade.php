@extends('dashboard.layout.sidenav-layout')
@section('content')
    @include('dashboard.components.permission.list')
    @include('dashboard.components.permission.delete')
    @include('dashboard.components.permission.create')
    @include('dashboard.components.permission.update')
@endsection
