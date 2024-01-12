{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Estados de Pago')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Gesti&oacute;n de Estados de Pago</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Boton para agregar --}}
                        <div class="btn-group align-self-center">
                            <a href="/payment_states/create" type="button" class="btn btn-success">
                                <i class="fas fa-plus"></i> Nuevo Estado
                            </a>
                        </div>
                        {{-- FIN Boton para agregar --}}
                    </div>
                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="data-table" class="table table-hover table-bordered text-center">
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
                                    $count = 0;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        @php
                                            $count++;
                                        @endphp
                                        <td>{{ $count }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            {{-- @if (Auth::user()->role == 'admin') --}}
                                            {{-- boton para modificar --}}
                                            <a class="btn btn-primary p-2"
                                                href="/payment_states/edit/{{ $item->idPaymentState }}">Modificar</a>
                                            {{-- @endif --}}
                                            {{-- boton para eliminar --}}
                                            <button class="btn btn-danger p-2"
                                                url="/payment_states/destroy/{{ $item->idPaymentState }}"
                                                onclick="destroy(this, 'Se eliminara el estado {{ $item->name }}','El estado fue eliminado con exito', 'El estado NO fue eliminado')"
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

