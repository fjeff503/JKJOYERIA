@extends('layouts.login')

{{-- Definimos el titulo --}}
@section('title', 'Registro')

@section('content')
<div class="container text-white">
    <div class="row justify-content-center">
        <div class="col-md-6">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h3 class="text-center mb-3">Registra tu cuenta</h3>
                        <br>
                        {{-- Nombre --}}
                <div class="m-3">
                    <label for="name" class="col-form-label text-md-end fw-bold">Nombre:</label>
                    <input id="name" type="text" style="background-color: #1c2433;" class="form-control text-white border-light @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="m-3">
                    <label for="email" class="col-form-label text-md-end fw-bold">Correo Electrónico:</label>
                    <input id="email" type="email" style="background-color: #1c2433;" class="form-control text-white border-light @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="m-3">
                    <label for="password" class="col-form-label text-md-end fw-bold">Contraseña:</label>
                    <input id="password" type="password" style="background-color: #1c2433;" class="form-control text-white border-light @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Confirmar Password --}}
                <div class="m-3">
                    <label for="password-confirm" class="col-form-label text-md-end fw-bold">Confirmar Contraseña:</label>
                    <input id="password-confirm" type="password" style="background-color: #1c2433;" class="form-control text-white border-light" name="password_confirmation" required autocomplete="new-password">
                </div>

                {{-- Botón --}}
                <div class="mt-3 mb-4 text-center">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-lg text-white col-8 mr-3"
                            style="background-color: #615fff; border-color: #615fff;">
                            Registrarse
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
@endsection
