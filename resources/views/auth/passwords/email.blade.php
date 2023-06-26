@extends('layouts.loginApp')

@section('title', 'Obnovit heslo | Rosalana')

@section('content')

            <div class="card">
            <h2 class="animate__animated animate__fadeInDown">Zapoměl jsi heslo?</h2>
                <p class="animate__animated animate__fadeInDown">Odkaz ti pošleme na e-mail</p>


                
                <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                <div class="input animate__animated animate__fadeInLeft">
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <label class="input-label">E-mail</label>
                </div>

                <div id="emailError" class="invalid-feedback d-block" role="alert"></div>


                    
                
                <button type="submit" class="button-action animate__animated animate__pulse">
                    <span class="button-content">Odeslat odkaz</span>
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>
                
                <div id="emailSuccess" class="alert alert-success" role="alert"></div>
                <p>Už sis vzpomněl? <a id="login" class="a text-primary" href="{{ route('login') }}">Přihlaš se</a></p>
                    
            </form>
                
    </div>

@endsection
