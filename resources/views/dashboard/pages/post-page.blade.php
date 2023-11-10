@extends('dashboard.layout.sidenav-layout')
@section('content')
    @include('dashboard.components.post.list')
    @include('dashboard.components.post.delete')
    @include('dashboard.components.post.create')
    @include('dashboard.components.post.update')
@endsection
