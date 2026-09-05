@extends('layouts.dashboard-sidenav')
@section('title','Product Page')
@section('content')
    @include('backend.product.product-list')
    @include('backend.product.product-create')
    @include('backend.product.product-update')
    @include('backend.product.product-delete')
@endsection

