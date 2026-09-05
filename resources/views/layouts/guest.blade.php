@extends('layouts.app')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo"><i data-lucide="building-2"></i></div>
        @yield('content')
    </div>
</div>
@endsection
