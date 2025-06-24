@extends('layouts.login')

{{-- Definimos el titulo --}}
@section('title', 'Recuperar Contraseña')

@section('content')
<div class="container text-white">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <h3 class="text-center mb-3">¿Olvidaste tu contraseña?</h3>

                {{-- Mensaje de éxito --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Email --}}
                <div class="m-3">
                    <label for="email" class="col-form-label text-md-end fw-bold">Correo Electrónico:</label>
                    <input id="email" type="email" style="background-color: #1c2433;" 
                           class="form-control text-white border-light @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Botones: Enviar y Cancelar --}}
<div class="mt-3 mb-4 text-center">
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-lg text-white col-8 mr-3"
            style="background-color: #615fff; border-color: #615fff;">
            Enviar enlace de recuperación
        </button>

        <a href="{{ route('login') }}" class="btn btn-lg text-white col-3"
            style="background-color: #6c757d; border-color: #6c757d;">
            Cancelar
        </a>
    </div>
</div>

            </form>
        </div>
    </div>
</div>
@endsection
