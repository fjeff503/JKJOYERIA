{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Proveedores | Crear')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection


<!-- Incluye los archivos de inputmask -->
<script src="{{ asset('InputMask/inputmask.min.js') }}"></script>

<!-- Agrega un script para inicializar la máscara en el campo de teléfono -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Inputmask({
            mask: '(999)999-9999',
            placeholder: ''
        }).mask('#phone');
        Inputmask({
            mask: '(999)999-9999',
            placeholder: ''
        }).mask('#whatsapp');
    });
</script>


{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Crear Proveedores</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form id="Formulario" action="/providers/store" method="POST">
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
                            <div class="col-12 mt-4">
                                <label for="address" class="form-label">Direcci&oacute;n:</label>
                                <textarea rows="5" type="text" class="form-control" placeholder="Dirección" id="address"
                                    name="address" maxlength="255" value="{{ old('address') }}"></textarea>
                                @error('address')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-4">
                                <label for="phone" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono" id="phone"
                                    name="phone" maxlength="13" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-4">
                                <label for="whatsapp" class="form-label">WhatsApp:</label>
                                <input type="text" class="form-control" placeholder="WhatsApp" id="whatsapp"
                                    name="whatsapp" maxlength="13" value="{{ old('whatsapp') }}">
                                @error('whatsapp')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <label for="facebook" class="form-label">Facebook:</label>
                                <input type="text" class="form-control" placeholder="Facebook url" id="facebook"
                                    name="facebook" maxlength="255" value="{{ old('facebook') }}">
                                @error('facebook')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <label for="description" class="form-label">Descripci&oacute;n:</label>
                                <textarea rows="5" type="text" class="form-control" placeholder="Descripción" id="description"
                                    name="description" maxlength="255" value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 text-center pt-3">
                                <button onclick="deshabilitar(this)" class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a id="btnCancelar" class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/providers">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
{{-- Para escribir lo mismo en el campo whatsapp --}}
<script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#phone').on('input', function() {
                $('#whatsapp').val($(this).val());
            });
        });
    </script>
@endsection

{{-- Incluimos el script para desactivar los botones --}}
@include('components.procesando')

