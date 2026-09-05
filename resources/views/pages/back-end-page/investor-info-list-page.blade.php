@extends('layouts.dashboard-sidenav')
@section('title','Investor Info List Page')
@section('content')
    @include('backend.investment.invest-list.invest-list')
    @include('backend.investment.invest-list.invest-create')
    @include('backend.investment.invest-list.invest-update')
    @include('backend.investment.invest-list.invest-delete')
@endsection
