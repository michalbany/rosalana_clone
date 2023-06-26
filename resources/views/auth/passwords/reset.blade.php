@extends('layouts.loginApp')

@section('title', 'Obnovit heslo | Rosalana')

@section('content')

            <div class="card">
            <h2 class="animate__animated animate__fadeInDown">Zapoměl jsi heslo?</h2>
                <p class="animate__animated animate__fadeInDown">Vytvoř si nové heslo</p>
                

                
                    <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">


                <div class="input animate__animated animate__fadeInLeft">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                    <label class="input-label">E-mail</label>
                </div>

                <div id="emailError" class="invalid-feedback d-block" role="alert"></div>
                            


                <div class="input password animate__animated animate__fadeInLeft" style="animation-delay: 0.05s;">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                    <label class="input-label">Heslo</label>
                    <a class="eye"><i class="fa-solid fa-eye"></i></a>
                </div>
                            
                <div id="passwordError" class="invalid-feedback d-block" role="alert"></div>
                            

                <div class="input password animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    <label class="input-label">Heslo</label>
                    <a class="eye"><i class="fa-solid fa-eye"></i></a>
                </div>
                
                
                <button type="submit" class=" button-action animate__animated animate__pulse">
                    <span class="button-content">Obnovit heslo</span>
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>
                        

                    </form>
                
</div>
@endsection
