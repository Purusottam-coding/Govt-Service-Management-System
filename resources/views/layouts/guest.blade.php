@extends('layouts.app')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo"><i class="bi bi-building"></i></div>
        @yield('content')
    </div>
</div>
@endsection
