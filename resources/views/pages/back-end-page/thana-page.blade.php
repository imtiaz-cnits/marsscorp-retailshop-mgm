@extends('layouts.dashboard-sidenav')
@section('title','Thana Page')
@section('content')
    @include('backend.thana.thana-list')
    @include('backend.thana.thana-create')
    @include('backend.thana.thana-update')
    @include('backend.thana.thana-delete')
@endsection
