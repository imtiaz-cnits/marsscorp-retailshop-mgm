@extends('layouts.dashboard-sidenav')
@section('title','Sub Category Page')
@section('content')
    @include('backend.sub-category.sub-category-list')
    @include('backend.sub-category.sub-category-create')
    @include('backend.sub-category.sub-category-update')
    @include('backend.sub-category.sub-category-delete')
@endsection
