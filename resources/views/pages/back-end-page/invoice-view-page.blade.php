@extends('layout.dashboard-sidenav')
@section('title','Invoice Page')
@section('content')
    @include('components.back-end.view-invoice.invoice-list')
    @include('components.back-end.view-invoice.invoice-update')
    @include('components.back-end.view-invoice.invoice-full-edit')
@endsection



