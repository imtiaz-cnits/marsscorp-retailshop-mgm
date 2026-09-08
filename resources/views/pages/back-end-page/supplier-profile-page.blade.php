@extends('layouts.dashboard-sidenav')
@section('title', 'Supplier Profile - MARSS CORPORATION')

@section('topbar_back_button')
  <a href="javascript:void(0)" onclick="if(window.history.length > 1 && document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href = '{{ url('/supplier-list') }}'; }" class="topbar-back-btn" title="Back">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
@endsection

@section('content')
    @include('backend.supplier.supplier-profile')
@endsection

