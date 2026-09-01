@extends('layout.dashboard-sidenav')
@section('title','Investor Info Page')
@section('content')
    @include('components.back-end.investment.investor-info.investor-info-list')
    @include('components.back-end.investment.investor-info.investor-info-create')
    @include('components.back-end.investment.investor-info.investor-info-update')
    @include('components.back-end.investment.investor-info.investor-info-delete')
@endsection
