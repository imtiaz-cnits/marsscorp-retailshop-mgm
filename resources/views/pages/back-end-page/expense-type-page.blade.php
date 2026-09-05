@extends('layouts.dashboard-sidenav')
@section('title','Expence Type Page')
@section('content')
    @include('backend.expense.expense-type.expense-type-list')
    @include('backend.expense.expense-type.expense-type-create')
    @include('backend.expense.expense-type.expense-type-update')
    @include('backend.expense.expense-type.expense-type-delete')
@endsection
