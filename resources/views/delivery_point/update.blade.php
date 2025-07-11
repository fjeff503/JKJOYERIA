{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Puntos de entrega | Actualizar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Actualizar Puntos de Entrega</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form action="/delivery_points/update/{{ $deliveryPoint->idDeliveryPoint }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                <label for="name" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="name"
                                    name="name" maxlength="50" value="{{ $deliveryPoint->name }}">
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-12 mt-lg-0 mt-md-3">
                                <label for="hour" class="form-label">Hora:</label>
                                <input type="time" class="form-control" id="hour" name="hour"
                                    value="{{ $deliveryPoint->hour }}">
                                @error('hour')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idDay" class="form-label">D&iacute;a:</label>
                                <select name="idDay" id="idDay" class="form-control" style="height: calc(3rem);">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($days as $item)
                                        <option value="{{ $item->idDay }}"
                                            @if ($deliveryPoint->idDay == $item->idDay) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('idDay')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idParcel" class="form-label">Encomendista:</label>
                                <select name="idParcel" id="idParcel" class="form-control" style="height: calc(3rem);">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($parcels as $item)
                                        <option value="{{ $item->idParcel }}"
                                            @if ($deliveryPoint->idParcel == $item->idParcel) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('idParcel')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label for="description" class="form-label">Descripci&oacute;n:</label>
                                <textarea class="form-control" placeholder="Comentarios" id="description" name="description" maxlength="250">{{ $deliveryPoint->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 text-center pt-3">
                                <button
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Actualizar</button>
                                <a class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/delivery_points">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
