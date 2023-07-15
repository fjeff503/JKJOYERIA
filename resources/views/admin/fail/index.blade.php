{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Errores')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Historial de errores</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- Tabla donde muestro la informacion --}}
                    <div class="table-responsive pt-4">
                        <table id="data-table" class="table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>N°</th>
                                    <th>Tabla</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Mensaje</th>
                                    <th>Archivo</th>
                                    <th>Linea</th>
                                    <th>Fecha</th>
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
                                        <td>{{ $item->tableName }}</td>
                                        <td>{{ $item->action }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td>{{ $item->file }}</td>
                                        <td>{{ $item->line }}</td>
                                        <td>{{ $item->created_at }}</td>   
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

    {{-- Incliomos dataTable --}}
    <script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    @include('components.dataTable', ['tablaId' => 'data-table'])
@endsection

