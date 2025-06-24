@extends('layouts.login')

@section('title', 'Iniciar Sesion')

@section('content')
<div class="container text-white">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="text-center mb-3">Inicia sesi&oacute;n en tu cuenta</h3>
                <br>
                {{-- Email --}}
                <div class="m-3">
                    <label for="email" class="col-form-label text-md-end fw-bold"><strong>Correo Electr&oacute;nico</strong></label>
                        <input id="email" type="email" style="background-color: #1c2433;" class="form-control text-white border-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                {{-- Password --}}
                <div class="mt-3 ml-3 mr-3 d-flex justify-content-between align-items-center">
                    <label for="password" class="col-form-label text-md-end"><strong>Contrase&ntilde;a</strong></label>
                    @if (Route::has('password.request'))
                            <a style="color: #615fff;" href="{{ route('password.request') }}">
                                <strong>¿Olvidaste tu contraseña?</strong>
                            </a>
                        @endif 
                </div>
<div class="mb-3 ml-3 mr-3">         
                    <input id="password" type="password" style="background-color: #1c2433;" class="form-control text-white border-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                {{-- Submit --}}
                <div class="mt-3 mr-2 ml-2 mb-4">
                    <br>
                    <div class="col-12">
                        <button type="submit" class="btn w-100 text-white btn-lg" style="background-color: #615fff; border-color: #615fff;">
                            <strong>Iniciar sesión</strong>
                        </button>
                    </div>
                </div>
                <br>
                {{-- Registrate --}}
                <div class="text-center mt-4">
                    <span class="text-white">¿No tienes cuenta?</span>
                    <a href="{{ route('register') }}" style="color: #615fff;"><strong>Reg&iacute;strate</strong></a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
