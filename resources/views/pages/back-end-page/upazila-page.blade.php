@extends('layouts.dashboard-sidenav')
@section('title','Upazila Page')
@section('content')
    @include('backend.upazila.upazila-list')
    @include('backend.upazila.upazila-create')
    @include('backend.upazila.upazila-update')
    @include('backend.upazila.upazila-delete')
@endsection
