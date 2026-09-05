@extends('layouts.dashboard-sidenav')
@section('title','Category Page')
@section('content')
    @include('backend.category.category-list')
    @include('backend.category.category-create')
    @include('backend.category.category-update')
    @include('backend.category.category-delete')
@endsection
