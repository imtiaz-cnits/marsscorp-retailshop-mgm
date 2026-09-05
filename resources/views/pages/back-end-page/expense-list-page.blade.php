@extends('layouts.dashboard-sidenav')
@section('title','Expence Type Page')
@section('content')
    @include('backend.expense.expense-list.expense-list')
    @include('backend.expense.expense-list.expense-create')
    @include('backend.expense.expense-list.expense-update')
    @include('backend.expense.expense-list.expense-delete')
@endsection
