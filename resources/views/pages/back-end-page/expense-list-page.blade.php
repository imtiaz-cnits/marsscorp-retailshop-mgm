@extends('layout.dashboard-sidenav')
@section('title','Expence Type Page')
@section('content')
    @include('components.back-end.Expense.expense-list.expense-list')
    @include('components.back-end.Expense.expense-list.expense-create')
    @include('components.back-end.Expense.expense-list.expense-update')
    @include('components.back-end.Expense.expense-list.expense-delete')
@endsection
