@extends('layout.dashboard-sidenav')
@section('title','Customer Page')
@section('content')
    @include('components.back-end.Customer.customer-due.customer-due-list')
    @include('components.back-end.Customer.customer-due.customer-due-collection')
@endsection
