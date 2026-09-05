@extends('layouts.dashboard-sidenav')
@section('title','Customer Page')
@section('content')
    @include('backend.customer.customer-list')
    @include('backend.customer.customer-create')
    @include('backend.customer.customer-update')
    @include('backend.customer.customer-delete')
@endsection
