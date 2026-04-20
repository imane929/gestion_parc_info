@extends('layouts.app')

@section('title', trim($__env->yieldContent('title', 'AssetFlow')))

@section('content')
    @yield('content')
@endsection
