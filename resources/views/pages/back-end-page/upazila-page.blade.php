@extends('layout.dashboard-sidenav')
@section('title','Upazila Page')
@section('content')
    @include('components.back-end.Upazila.upazila-list')
    @include('components.back-end.Upazila.upazila-create')
    @include('components.back-end.Upazila.upazila-update')
    @include('components.back-end.Upazila.upazila-delete')
@endsection
