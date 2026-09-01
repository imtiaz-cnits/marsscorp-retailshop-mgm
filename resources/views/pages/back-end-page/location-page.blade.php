@extends('layout.dashboard-sidenav')
@section('title','Location Page')
@section('content')
    @include('components.back-end.location.location-list')
    @include('components.back-end.location.location-create')
    @include('components.back-end.location.location-update')
    @include('components.back-end.location.location-delete')
@endsection
