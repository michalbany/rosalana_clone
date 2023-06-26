@extends('layouts.loginApp')

@section('title', 'Přihlášení | Rosalana')

@section('content')

            <div class="card">

                <h2 class="animate__animated animate__fadeInDown">Rádi tě znovu vidíme</h2>
                <p class="animate__animated animate__fadeInDown">Vítej zpátky! Přihlaš se a začni psát.</p>
                    <form id="loginForm" action="{{ route('login') }}" method="post">
                        @csrf

                        <div class="input animate__animated animate__fadeInLeft" > <!--TEMP: pro jakýkoli input-->
                            <!--<i class="fa-solid fa-user"></i>-->
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label class="input-label">E-mail</label>
                        </div>

                        <div class="input password animate__animated animate__fadeInLeft"style="animation-delay: 0.1s;">
                            <!--<i class="fa-solid fa-lock"></i>-->
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                            <label class="input-label">Heslo</label>
                            <a class="eye"><i class="fa-solid fa-eye"></i></a>
                        </div>


                        <div class="nextToBar animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">

                        <!--REVIEW: nevim jestli funguje remember me-->
                        <div class="checkbox">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="display: none;">
                            <label for="remember" class="checkbox-label">
                                <svg width="14px" height="14px" viewBox="0 0 18 18">
                                    <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                    <polyline points="1 9 7 14 15 4"></polyline>
                                </svg>
                            </label>
                            <p class="checkbox-text" id="checkboxText">Pamatuj si mě</p>
                        </div>


                            <a id="forgot" class="a text-secondary" href="{{ route('password.request') }}">Zapoměli jste heslo?</a>
                        </div>


                        <div id="emailError" class="invalid-feedback d-block" role="alert"></div>

                        <button type="submit" class="button-action animate__animated animate__pulse">
                        <span class="button-content">Přihlásit se</span>
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button>


                        <p>Ještě nemáš učet?<a id="create" class="a text-primary" href="{{ route('register') }}"> Registruj se zdarma</a></p>




                    </form>


</div>
@endsection


@section('scripts')
    <script>
        
    </script>
@endsection




