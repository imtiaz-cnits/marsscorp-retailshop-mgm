@extends('layout.dashboard-sidenav')
@section('title','Opening Balance Page')
@section('content')
    @include('components.back-end.opening-balance.opening-balance-list')
    @include('components.back-end.opening-balance.opening-balance-create')
@endsection