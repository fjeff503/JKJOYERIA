{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Estado Paquetes | Crear')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Crear Estados de Paquetes</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form id="Formulario" action="/package_states/store" method="POST">
                        @csrf
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            <div class="col-12">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="name"
                                    name="name" maxlength="50" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <label for="description" class="form-label">Descripci&oacute;n:</label>
                                <textarea class="form-control" placeholder="Comentarios" id="description" name="description" maxlength="250"></textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 text-center pt-3">
                                <button onclick="deshabilitar(this)"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a id="btnCancelar"
                                    class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/package_states">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Incluimos el script para desactivar los botones --}}
@include('components.procesando')
