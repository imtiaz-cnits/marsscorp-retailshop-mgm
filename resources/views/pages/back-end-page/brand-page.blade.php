@extends('layouts.dashboard-sidenav')
@section('title','Brand Page')
@section('content')
    @include('backend.brand.brand-list')
    @include('backend.brand.brand-create')
    @include('backend.brand.brand-update')
    @include('backend.brand.brand-delete')
@endsection
