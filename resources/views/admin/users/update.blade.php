{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Usuario | Actualizar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    <h1 class="text-center">Actualizar Usuario</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="/users/update/{{ $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            {{-- Nombre --}}
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" maxlength="50" required>
                                @error('name')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label fw-bold">Email:</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" maxlength="255" readonly required>
                                @error('email')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Rol --}}
                            <div class="col-md-12 mb-3">
                                <label for="idRole" class="form-label fw-bold">Rol:</label>
                                <select name="idRole" id="idRole" class="form-control" required>
                                    <option value="">-- Seleccionar Rol --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->idRole }}"
                                            {{ $user->idRole == $role->idRole ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idRole')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Botones --}}
                            <div class="col-12 text-center pt-3">
                                <button type="submit"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">
                                    Actualizar
                                </button>
                                <a class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/users">Cancelar</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
