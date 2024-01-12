{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Productos | Crear')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Crear Productos</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                    {{-- CUERPO PARA CREAR --}}
                    <form action="/products/store" method="POST">
                        @csrf
                        <div class="row mx-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="codeProduct" class="form-label">C&oacute;digo Interno:</label>
                                <input type="text" class="form-control" placeholder="Código Interno" id="codeProduct"
                                    name="codeProduct" maxlength="50" value="{{ old('codeProduct') }}">
                                @error('codeProduct')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="codeProductProvider" class="form-label">C&oacute;digo Proveedor:</label>
                                <input type="text" class="form-control" placeholder="Código Proveedor" id="codeProductProvider"
                                    name="codeProductProvider" maxlength="50" value="{{ old('codeProductProvider') }}">
                                @error('codeProductProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="stock" class="form-label">Stock:</label>
                                <input type="number" class="form-control" id="stock"
                                    name="stock" min="1" value="{{ old('stock') }}">
                                @error('stock')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-8 col-md-12 mt-3">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="name"
                                    name="name" maxlength="50" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mt-3">
                                <label for="sellPrice" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="sellPrice"
                                    name="sellPrice" min="1" step="any" value="{{ old('sellPrice') }}">
                                @error('sellPrice')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idCategory" class="form-label">Categor&iacute;a:</label>
                                <select name="idCategory" id="idCategory" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($categories as $item)
                                    <option value="{{$item->idCategory}}" @if (old('idCategory') == $item->idCategory) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('idCategory')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idProvider" class="form-label">Proveedor:</label>
                                <select name="idProvider" id="idProvider" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($providers as $item)
                                    <option value="{{$item->idProvider}}" @if (old('idProvider') == $item->idProvider) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('idProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- agregar imagenes --}}
                            <div class="col-12 mt-3 text-center">
                                <label for="imageInputs" class="form-label">Fotos:</label>
                                <br>
                                <button type="button" onclick="addImageInput()" class="btn btn-info btn-sm col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Agregar Imagen</button>               
                            </div>

                            <div class="row col-12 mt-3 text-center" id="imageInputs">
                                
                            </div>

                            <div class="col-12 mt-3">
                                <label for="description" class="form-label">Descripci&oacute;n:</label>
                                <textarea class="form-control" placeholder="Comentarios" id="description" name="description" maxlength="250">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 text-center pt-3 mb-3">
                                <button
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/products">Cancelar</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function addImageInput() {
        const container = document.getElementById('imageInputs');

        // Crea un nuevo input de tipo texto
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'images[]'; // Usar corchetes para indicar un array en PHP
        input.placeholder = 'URL de la imagen';
        input.className = 'form-control col-12';

        // Crea un botón para quitar el campo de entrada si es necesario
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-lg btn-danger col-12';
        // Añade un ícono de basurero al botón
        const trashIcon = document.createElement('i');
        trashIcon.className = 'fas fa-trash';
        removeButton.appendChild(trashIcon);

        removeButton.onclick = function () {
            container.removeChild(wrapper1);
            container.removeChild(wrapper2);
        };

        // Crea un contenedor para el input y el botón de eliminación
        const wrapper1 = document.createElement('div');
        wrapper1.className = 'col-10 mt-2';
        wrapper1.appendChild(input);

        // Crea un contenedor para el input y el botón de eliminación
        const wrapper2 = document.createElement('div');
        wrapper2.className = 'col-2 mt-2';
        wrapper2.appendChild(removeButton);

        // Agrega el contenedor al contenedor principal
        container.appendChild(wrapper1);
        container.appendChild(wrapper2);
    }
</script>
