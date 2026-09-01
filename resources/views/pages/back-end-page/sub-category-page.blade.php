@extends('layout.dashboard-sidenav')
@section('title','Sub Category Page')
@section('content')
    @include('components.back-end.Sub-Category.sub-category-list')
    @include('components.back-end.Sub-Category.sub-category-create')
    @include('components.back-end.Sub-Category.sub-category-update')
    @include('components.back-end.Sub-Category.sub-category-delete')
@endsection
