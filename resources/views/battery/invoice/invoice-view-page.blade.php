@extends('layouts.dashboard-sidenav')
@section('title', 'Battery - Invoices')
@section('content')
    @include('battery.invoice.invoice-list')
    @include('battery.invoice.invoice-update')
    @include('battery.invoice.invoice-full-edit')
@endsection
