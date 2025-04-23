@extends('layouts.app')

@section('sidebar')
    @include('partials.employee.sidebar')
@endsection

@section('content')
    @yield('employee-content')
@endsection
