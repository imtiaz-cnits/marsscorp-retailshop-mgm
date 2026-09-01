@extends('layout.dashboard-sidenav')
@section('title','Thana Page')
@section('content')
    @include('components.back-end.Thana.thana-list')
    @include('components.back-end.Thana.thana-create')
    @include('components.back-end.Thana.thana-update')
    @include('components.back-end.Thana.thana-delete')
@endsection
