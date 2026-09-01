@extends('layout.dashboard-sidenav')
@section('title','Supplier Page')
@section('content')
    @include('components.back-end.Supplier.supplier-list')
    @include('components.back-end.Supplier.supplier-create')
    @include('components.back-end.Supplier.supplier-update')
    @include('components.back-end.Supplier.supplier-delete')
@endsection
