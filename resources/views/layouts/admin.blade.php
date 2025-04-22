@extends('layouts.app')

@section('sidebar')
    @include('partials.admin.sidebar')
@endsection

@section('content')
    @yield('admin-content')
@endsection
