@extends('layouts.app')

@section('sidebar')
    @include('partials.company.sidebar')
@endsection

@section('content')
    @yield('company-content')
@endsection
