@extends('layouts.dashboard-sidenav')
@section('title','District Page')
@section('content')
    @include('backend.district.district-list')
    @include('backend.district.district-create')
    @include('backend.district.district-update')
    @include('backend.district.district-delete')
@endsection
