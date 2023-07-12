{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Categorias')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Categor&iacute;as</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Paginacion Seleccionar de cuanto sera el salto --}}
                        <form action="/categories" method="GET">
                            <div class="form-group">
                                <label for="per_page">Mostrar por página:</label>
                                <select name="per_page" id="per_page" class="form-control" onchange="this.form.submit()">
                                    <option value="5" {{ session('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ session('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ session('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="100" {{ session('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </form>

                        {{-- FIN Paginacion Seleccionar de cuanto sera el salto --}}

                        {{-- Boton para agregar --}}
                        <div class="btn-group align-self-center">
                            <a href="/categories/create" type="button" class="btn btn-success">
                                <i class="fas fa-plus"></i> Nueva Categor&iacute;a
                            </a>
                        </div>
                        {{-- FIN Boton para agregar --}}
                    </div>

                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="category_listing" class="table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = ($categories->currentPage() - 1) * $categories->perPage();
                                @endphp
                                @foreach ($categories as $category)
                                    <tr>
                                        @php
                                            $count++;
                                        @endphp
                                        <td>{{ $count }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            {{-- @if (Auth::user()->role == 'admin') --}}
                                            {{-- boton para modificar --}}
                                            <a class="btn btn-primary btn-sm"
                                                href="/categories/edit/{{ $category->idCategory }}">Modificar</a>
                                            {{-- @endif --}}
                                            {{-- boton para eliminar --}}
                                            <button class="btn btn-danger btn-sm"
                                                url="/categories/destroy/{{ $category->idCategory }}"
                                                onclick="destroy(this, 'Se eliminara la categoría {{ $category->name }}','La categoria fue eliminada con exito')" token="{{ csrf_token() }}">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- FIN Tabla donde muestro la informacion --}}
                </div>


                {{-- Paginacion --}}
                <div class="pagination justify-content-center">
                    <ul class="pagination">
                        <li class="page-item {{ $categories->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Página anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item {{ $categories->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link">
                                <span aria-hidden="true">Página {{ $categories->currentPage() }} de
                                    {{ $categories->lastPage() }}</span>
                            </a>
                        </li>
                        <li
                            class="page-item {{ $categories->currentPage() == $categories->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Página siguiente">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- FIN Paginacion --}}

            </div>
        </div>
    </div>

    {{-- incluimos el archivo para SweetAlert --}}
    <script src="{{ asset('SweetAlert/sweetalert.min.js') }}"></script>

    {{-- Incluimos el script para mensajes satisfactorios --}}
    @include('components.exito')
    
    {{--Incluimos el script para mensajes satisfactorios al eliminar --}}
    @include('components.eliminado')
@endsection
