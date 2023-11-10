@extends('dashboard.layout.sidenav-layout')
@section('content')
    @include('dashboard.components.category.category-list')
    @include('dashboard.components.category.category-delete')
    @include('dashboard.components.category.category-create')
    @include('dashboard.components.category.category-update')
@endsection
