@extends('layout.dashboard-sidenav')
@section('title','Return List Page')
@section('content')
    @include('components.back-end.Return.return-list')
    @include('components.back-end.Return.return-create')
    @include('components.back-end.Return.return-update')
    @include('components.back-end.Return.return-delete')
@endsection
