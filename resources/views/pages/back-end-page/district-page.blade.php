@extends('layout.dashboard-sidenav')
@section('title','District Page')
@section('content')
    @include('components.back-end.District.district-list')
    @include('components.back-end.District.district-create')
    @include('components.back-end.District.district-update')
    @include('components.back-end.District.district-delete')
@endsection
