{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Usuarios')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Gesti&oacute;n de Usuarios</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="data-table" class="table table-hover table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Tel&eacute;fono</th>
                                    <th>Foto</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
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
                                        <td>{{ $count }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->lastname }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>
                                            @if ($item->profile_photo)
                                                <img src="{{ $item->profile_photo }}" alt="Foto de Perfil">
                                            @else
                                                <p>Sin imagen</p>
                                            @endif
                                        </td>
                                        <td>{{ $item->role }}</td>
                                        <td>
                                            {{-- @if (Auth::user()->role == 'admin') --}}
                                            {{-- boton para modificar --}}
                                            <a class="btn btn-primary p-2"
                                                href="/users/edit/{{ $item->id }}">Modificar</a>
                                            {{-- @endif --}}
                                            {{-- boton para eliminar --}}
                                            <button class="btn btn-danger p-2" url="/users/destroy/{{ $item->id }}"
                                                onclick="destroy(this, 'Se eliminara el usuario {{ $item->name }}','El usuario fue eliminado con exito', 'El usuario NO fue eliminado')"
                                                token="{{ csrf_token() }}">Eliminar</button>
                                        </td>
                                    </tr>
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

    {{-- Incliomos dataTable --}}
    <script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    @include('components.dataTable', ['tablaId' => 'data-table'])
@endsection
