{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Puntos de Envio')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Gesti&oacute;n de Puntos de Entrega</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Boton para agregar --}}
                        @if (Auth::user()->role->name === 'admin')
                            <div class="btn-group align-self-center">
                                <a href="/delivery_points/create" type="button" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Nuevo Punto de Entrega
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
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Encomendista</th>
                                    <th>D&iacute;a</th>
                                    <th>Hora</th>
                                    <th>Descripci&oacute;n</th>
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
                                        <td>{{ $count }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->parcel }}</td>
                                        <td>{{ $item->day }}</td>
                                        <td>{{ $item->hour }}</td>
                                        <td>{{ $item->description }}</td>
                                        @if (Auth::user()->role->name === 'admin')
                                            <td>
                                                {{-- @if (Auth::user()->role == 'admin') --}}
                                                {{-- boton para modificar --}}
                                                <a class="btn btn-primary p-2"
                                                    href="/delivery_points/edit/{{ $item->idDeliveryPoint }}">Modificar</a>
                                                {{-- @endif --}}
                                                {{-- boton para eliminar --}}
                                                <button class="btn btn-danger p-2"
                                                    url="/delivery_points/destroy/{{ $item->idDeliveryPoint }}"
                                                    onclick="destroy(this, 'Se eliminara el punto de envio {{ $item->name }}','El punto de envio fue eliminado con exito', 'El punto de envio NO fue eliminada')"
                                                    token="{{ csrf_token() }}">Eliminar</button>
                                            </td>
                                        @endif
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
