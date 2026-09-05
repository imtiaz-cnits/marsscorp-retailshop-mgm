@extends('layouts.dashboard-sidenav')
@section('title','Investor Info Page')
@section('content')
    @include('backend.investment.investor-info.investor-info-list')
    @include('backend.investment.investor-info.investor-info-create')
    @include('backend.investment.investor-info.investor-info-update')
    @include('backend.investment.investor-info.investor-info-delete')
@endsection
