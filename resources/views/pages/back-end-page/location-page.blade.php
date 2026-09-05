@extends('layouts.dashboard-sidenav')
@section('title','Location Page')
@section('content')
    @include('backend.location.location-list')
    @include('backend.location.location-create')
    @include('backend.location.location-update')
    @include('backend.location.location-delete')
@endsection
