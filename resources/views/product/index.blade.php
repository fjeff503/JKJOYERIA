{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Productos')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Gesti&oacute;n de Productos</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Boton para agregar --}}
                        @if (Auth::user()->role->name === 'admin')
                            <div class="btn-group align-self-center">
                                <a href="/products/create" type="button" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Nuevo Producto
                                </a>
                            </div>
                        @endif
                        {{-- FIN Boton para agregar --}}
                    </div>
                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="data-table" class="table table-hover table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Cod Proveedor</th>
                                    <th>Nombre</th>
                                    @if (Auth::user()->role->name === 'admin')
                                        <th>Precio Compra</th>
                                    @endif
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Categor&iacute;a</th>
                                    <th>Proveedor</th>
                                    <th>Foto</th>
                                    @if (Auth::user()->role->name === 'admin')
                                        <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        @php
                                            $count++;
                                        @endphp
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->idProduct }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->codeProductProvider }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->name }}</td>
                                        @if (Auth::user()->role->name === 'admin')
                                            <td data-toggle="modal"
                                                data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                                ${{ $item->first()->buyPrice }}</td>
                                        @endif
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            ${{ $item->first()->sellPrice }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->stock }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->category }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            {{ $item->first()->provider }}</td>
                                        <td data-toggle="modal"
                                            data-target="#galleryModal{{ $item->first()->codeProduct }}">
                                            @if ($item->first()->fotos)
                                                <img src="{{ $item->first()->fotos }}" alt="{{ $item->first()->name }}">
                                            @else
                                                <p>Sin imagen</p>
                                            @endif
                                        </td>
                                        @if (Auth::user()->role->name === 'admin')
                                            <td>
                                                {{-- boton para modificar --}}
                                                <a class="btn btn-primary p-2"
                                                    href="/products/edit/{{ $item->first()->idProduct }}">Modificar</a>
                                                {{-- boton para eliminar --}}
                                                <button class="btn btn-danger p-2"
                                                    url="/products/destroy/{{ $item->first()->idProduct }}"
                                                    onclick="destroy(this, 'Se eliminara el producto {{ $item->first()->name }}','El producto fue eliminado con exito', 'El producto NO fue eliminado')"
                                                    token="{{ csrf_token() }}">Eliminar</button>
                                            </td>
                                        @endif
                                    </tr>

                                    {{-- creamos el modal para cada producto --}}
                                    <div class="modal fade" id="galleryModal{{ $item->first()->codeProduct }}"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="galleryModalLabel{{ $item->first()->codeProduct }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="galleryModalLabel{{ $item->first()->codeProduct }}">
                                                        {{ $item->first()->name }}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Mostrar aquí todas las fotos relacionadas con el producto -->
                                                    @if ($item->first()->fotos)
                                                        <div id="galleryCarouselLabel{{ $item->first()->codeProduct }}"
                                                            class="carousel slide">
                                                            <div class="carousel-inner">
                                                                @foreach ($item->pluck('fotos') as $i => $foto)
                                                                    @if ($foto)
                                                                        <div
                                                                            class="carousel-item{{ $i === 0 ? ' active' : '' }}">
                                                                            <img class="d-block w-100 h-100"
                                                                                src="{{ $foto }}"
                                                                                alt="{{ $item->first()->name }}">
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#galleryCarouselLabel{{ $item->first()->codeProduct }}"
                                                                data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#galleryCarouselLabel{{ $item->first()->codeProduct }}"
                                                                data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    <br>
                                                    <hr>
                                                    <br>
                                                    <h6>Descripci&oacute;n:</h6>
                                                    <p>{{ $item->first()->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- FIN Tabla donde muestro la informacion --}}
                </div>
            </div>
        </div>
    </div>

    {{-- incluimos el archivo para SweetAlert --}}
    <script src="{{ asset('SweetAlert/sweetalert.min.js') }}"></script>

    {{-- Incluimos el script para mensajes satisfactorios --}}
    @include('components.exito')

    {{-- Incluimos el script para mensajes de informacion --}}
    @include('components.info')

    {{-- Incluimos el script para mensajes satisfactorios al eliminar --}}
    @include('components.eliminado')

    {{-- Incluimos script de errores --}}
    @include('components.error')

    {{-- Incluimos dataTable --}}
    <script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    @include('components.dataTable', ['tablaId' => 'data-table'])
@endsection
