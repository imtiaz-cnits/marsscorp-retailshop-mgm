@extends('layouts.dashboard-sidenav')
@section('title','Return List Page')
@section('content')
    @include('backend.return.return-list')
    @include('backend.return.return-create')
    @include('backend.return.return-update')
    @include('backend.return.return-delete')
@endsection
