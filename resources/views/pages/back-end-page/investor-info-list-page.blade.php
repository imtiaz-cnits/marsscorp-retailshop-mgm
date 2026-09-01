@extends('layout.dashboard-sidenav')
@section('title','Investor Info List Page')
@section('content')
    @include('components.back-end.investment.invest-list.invest-list')
    @include('components.back-end.investment.invest-list.invest-create')
    @include('components.back-end.investment.invest-list.invest-update')
    @include('components.back-end.investment.invest-list.invest-delete')
@endsection
