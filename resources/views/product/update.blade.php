{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Productos | Actualizar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Actualizar Productos</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}

                    <form id="Formulario" action="/products/update/{{ $product->idProduct }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mx-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="codeProduct" class="form-label">C&oacute;digo Interno:</label>
                                <input type="text" class="form-control" placeholder="Código Interno" id="codeProduct"
                                    name="codeProduct" maxlength="50" value="{{ $product->codeProduct }}">
                                @error('codeProduct')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="codeProductProvider" class="form-label">C&oacute;digo Proveedor:</label>
                                <input type="text" class="form-control" placeholder="Código Proveedor"
                                    id="codeProductProvider" name="codeProductProvider" maxlength="50"
                                    value="{{ $product->codeProductProvider }}">
                                @error('codeProductProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-3">
                                <label for="stock" class="form-label">Stock:</label>
                                <input type="number" class="form-control" id="stock" name="stock" min="1"
                                    value="{{ $product->stock }}">
                                @error('stock')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-8 col-md-12 mt-3">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="name"
                                    name="name" maxlength="50" value="{{ $product->name }}">
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mt-3">
                                <label for="sellPrice" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="sellPrice" name="sellPrice" min="1"
                                    step="any" value="{{ $product->sellPrice }}">
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
                                        <option value="{{ $item->idCategory }}"
                                            @if ($product->idCategory == $item->idCategory) selected @endif>{{ $item->name }}</option>
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
                                        <option value="{{ $item->idProvider }}"
                                            @if ($product->idProvider == $item->idProvider) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('idProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- agregar imagenes --}}
                            <div class="col-12 mt-3">
                                <label for="imageInputs" class="form-label">Fotos:</label>
                                <input class="form-control form-control-lg" type="file" name="images[]" accept="image/*"
                                    multiple />
                                <!-- Aquí se agregarán las miniaturas de las imágenes seleccionadas -->
                                <div id="selectedImagesContainer" class="d-flex flex-wrap justify-content-center">
                                    @foreach ($product->galery as $image)
                                        <div id="selectedImages"
                                            class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 px-2 py-2 text-center">
                                            <img src="{{ $image->url }}" alt="Imagen Actual"
                                                class="img-fluid rounded">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="description" class="form-label">Descripci&oacute;n:</label>
                                <textarea class="form-control" placeholder="Comentarios" id="description" name="description" maxlength="250">{{ $product->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 text-center pt-3 mb-3">
                                <button onclick="deshabilitar(this)"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a id="btnCancelar"
                                    class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/products">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Incluimos el script para desactivar los botones --}}
@include('components.procesando')

{{-- Incluimos el script para mostrar Imagenes --}}
@include('components.mostrarImagenes')
