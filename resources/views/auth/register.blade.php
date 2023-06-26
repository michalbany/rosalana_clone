@extends('layouts.loginApp')

@section('title', 'Registrace | Rosalana')

@section('content')

<div class="card">
    <h2 class="animate__animated animate__fadeInDown">Už jen krůček</h2>
    <p class="animate__animated animate__fadeInDown">Vítej! Zaregistrujte se a začněte psát.</p>
    <form id="registerForm"method="POST" action="{{ route('register') }}">
        @csrf

<!-- NOTE: změnit povolenou delku jména a nicku kvůli designu -->
        <div class="input animate__animated animate__fadeInLeft" >
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" maxlength="30" autofocus>
            <label class="input-label">Jméno</label>
        </div>
        
        <div id="nameError" class="invalid-feedback d-block" role="alert"></div>

        

        <div class="input animate__animated animate__fadeInLeft" style="animation-delay: 0.02s;">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required maxlength="20" autocomplete="off">
            <label class="input-label">Username</label>
        </div>

        <div id="usernameError" class="invalid-feedback d-block" role="alert"></div>

        <div class="input animate__animated animate__fadeInLeft" style="animation-delay: 0.04s;">
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
            <label class="input-label">E-mail</label>
        </div>

        <div id="emailError" class="invalid-feedback d-block" role="alert"></div>

        <div class="input password animate__animated animate__fadeInLeft" style="animation-delay: 0.08s;">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            <label class="input-label">Heslo</label>
            <a class="eye"><i class="fa-solid fa-eye"></i></a>
        </div>

        
        
        <div class="input password animate__animated animate__fadeInLeft"style="animation-delay: 0.1s;">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <label class="input-label">Potvrďte heslo</label>
            <a class="eye"><i class="fa-solid fa-eye"></i></a>
        </div>
        
        <div id="passwordError" class="invalid-feedback d-block" role="alert"></div>



        
        
        
        <button type="submit" class="button-action animate__animated animate__pulse">
            <span class="button-content">Vytvořit účet</span>
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </button>
        <div id="registerSuccess" class="alert alert-success" role="alert"></div>
        
        <p>Již máte účet? <a id="login" class="a text-primary" href="{{ route('login') }}">Přihlaš se</a></p>
    </form>
</div>
@endsection

