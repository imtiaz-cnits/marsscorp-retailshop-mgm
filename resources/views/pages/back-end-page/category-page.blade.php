@extends('layout.dashboard-sidenav')
@section('title','Category Page')
@section('content')
    @include('components.back-end.Category.category-list')
    @include('components.back-end.Category.category-create')
    @include('components.back-end.Category.category-update')
    @include('components.back-end.Category.category-delete')
@endsection
