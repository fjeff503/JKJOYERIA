{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Ventas')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Gesti&oacute;n de Ventas</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- Boton para agregar --}}
                        <div class="btn-group align-self-center">
                            <a href="/sales/create" type="button" class="btn btn-success">
                                <i class="fas fa-plus"></i> Nueva Venta
                            </a>
                        </div>
                        {{-- FIN Boton para agregar --}}
                    </div>
                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="clientes-table" class="table table-hover table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>N° Venta</th>
                                    <th>Cliente</th>
                                    <th>Tel&eacute;fono</th>
                                    <th>Fecha</th>
                                    <th>Punto Entrega</th>
                                    <th>Estado paquete</th>
                                    <th>Estado pago</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->idSale }}</td>
                                        <td>{{ $item->client }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->delivery_point }}</td>
                                        <td>{{ $item->package_state }}</td>
                                        <td>{{ $item->payment_state }}</td>
                                        <td>${{ $item->total }}</td>
                                        <td>
                                            {{-- @if (Auth::user()->role == 'admin') --}}
                                            {{-- boton para modificar --}}
                                            <a class="btn btn-primary p-2" href="/sales/edit/{{ $item->idSale }}"><i
                                                    class="fas fa-edit menu-icon"></i></a>
                                            {{-- @endif --}}
                                            {{-- boton para eliminar --}}
                                            <button class="btn btn-danger p-2" url="/sales/destroy/{{ $item->idSale }}"
                                                onclick="destroy(this, 'Se eliminara la venta {{ $item->idSale }}','La venta fue eliminada con exito', 'La compra NO fue eliminada')"
                                                token="{{ csrf_token() }}"><i class="fas fa-trash menu-icon"></i></button>
                                            <a class="btn btn-info p-2" href="/sales/{{ $item->idSale }}/reporteEntrega"
                                                target="_blank"><i class="fas fa-file-alt menu-icon"></i></a>
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
    @include('components.dataTable', ['tablaId' => 'clientes-table'])
@endsection
