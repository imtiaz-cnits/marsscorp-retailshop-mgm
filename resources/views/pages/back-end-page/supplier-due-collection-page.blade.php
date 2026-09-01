@extends('layout.dashboard-sidenav')
@section('title','Supplier Page')
@section('content')
    @include('components.back-end.Supplier.supplier-due-collection.supplier-due-collection-list')
    @include('components.back-end.Supplier.supplier-due-collection.supplier-due')

@endsection
