@extends('layouts.dashboard-sidenav')
@section('title','Customer Page')
@section('content')
    @include('backend.customer.customer-due.customer-due-list')
    @include('backend.customer.customer-due.customer-due-collection')
@endsection
