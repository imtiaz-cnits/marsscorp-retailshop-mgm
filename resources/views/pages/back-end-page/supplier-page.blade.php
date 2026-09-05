@extends('layouts.dashboard-sidenav')
@section('title','Supplier Page')
@section('content')
    @include('backend.supplier.supplier-list')
    @include('backend.supplier.supplier-create')
    @include('backend.supplier.supplier-update')
    @include('backend.supplier.supplier-delete')
@endsection
