{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Categorias | Crear')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Crear Categor&iacute;as</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form action="/categories/store" method="POST">
                        @csrf
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            <div class="col-12">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="name"
                                    name="name" maxlength="50">
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
                            <div class="col-12 mt-2 text-center pt-3">
                                <button
                                    class="btn btn-primary btn-md col-xxl-4 col-xl-6 col-lg-8 col-md-10 col-sm-12">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection