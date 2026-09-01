@extends('layout.dashboard-sidenav')
@section('title','Expence Type Page')
@section('content')
    @include('components.back-end.Expense.expense-type.expense-type-list')
    @include('components.back-end.Expense.expense-type.expense-type-create')
    @include('components.back-end.Expense.expense-type.expense-type-update')
    @include('components.back-end.Expense.expense-type.expense-type-delete')
@endsection
