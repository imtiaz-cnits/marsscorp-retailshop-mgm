@extends('layout.dashboard-sidenav')
@section('title','Product Page')
@section('content')
    @include('components.back-end.Product.product-list')
    @include('components.back-end.Product.product-create')
    @include('components.back-end.Product.product-update')
    @include('components.back-end.Product.product-delete')
@endsection

