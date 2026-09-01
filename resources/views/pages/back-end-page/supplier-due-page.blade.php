@extends('layout.dashboard-sidenav')
@section('title','Supplier Due Page')
@section('content')
    @include('components.back-end.Supplier.supplier-due.supplier-due-list')
    @include('components.back-end.Supplier.supplier-due.supplier-due-collection')
@endsection
