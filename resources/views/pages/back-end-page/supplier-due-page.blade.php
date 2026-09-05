@extends('layouts.dashboard-sidenav')
@section('title','Supplier Due Page')
@section('content')
    @include('backend.supplier.supplier-due.supplier-due-list')
    @include('backend.supplier.supplier-due.supplier-due-collection')
@endsection
