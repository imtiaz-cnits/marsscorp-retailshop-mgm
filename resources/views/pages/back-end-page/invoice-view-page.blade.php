@extends('layouts.dashboard-sidenav')
@section('title','Invoice Page')
@section('content')
    @include('backend.view-invoice.invoice-list')
    @include('backend.view-invoice.invoice-update')
    @include('backend.view-invoice.invoice-full-edit')
@endsection



