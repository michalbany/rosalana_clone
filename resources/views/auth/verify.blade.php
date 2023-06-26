@extends('layouts.loginApp')

@section('title', 'Ověření e-mailu | Rosalana')



@section('content')

<div class="card">
    
        <h2 class="animate__animated animate__fadeInDown">Ověř si svůj e-mail</h2>
        <p class="animate__animated animate__fadeInDown">Radi bychom věděli, kdo jsi :)</p>
        
        
        @auth
            <div class="user-info animate__animated animate__fadeInLeft">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlásit se</a>
                </form>
            </div>
        @endauth


        

        <form method="POST" id="verifyLink" action="{{ route('verification.resend') }}">
            @csrf

            <button type="submit" class="button-action animate__animated animate__pulse">
            <span class="button-content">Odeslat nový odkaz</span>
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </button>
        
        <div id="resendSuccess" class="alert alert-success" role="alert"></div>
        <div id="resendError" class="invalid-feedback d-block" role="alert"></div>
        </form>


</div>

@endsection
