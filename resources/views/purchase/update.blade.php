{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Compras | Actualizar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Actualizar Compra {{ $purchase->idPurchase }}</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form action="/purchases/update/{{ $purchase->idPurchase }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            {{-- Proveedor --}}
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mt-3">
                                <label for="idProvider" class="form-label">Proveedor:</label>
                                <select name="idProvider" id="idProvider" class="form-control" style="height: calc(3rem);">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($providers as $item)
                                        <option value="{{ $item->idProvider }}"
                                            {{ $item->idProvider == $purchase->idProvider ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Voucher --}}
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex align-items-center mt-3">
                                <div class="me-3">
                                    <label for="voucher" class="form-label">Voucher</label>
                                    <input type="file" name="voucher" id="voucher"
                                        class="form-control @error('voucher') is-invalid @enderror">
                                </div>
                                <img id="previewImage" src="{{ $purchase->voucher }}" alt="Imagen Actual" class="ml-2 mr-0"
                                    style="width: 4.5rem; height: 4.5rem; cursor: pointer;" data-bs-toggle="modal"
                                    data-bs-target="#imageModal">
                            </div>
                            {{-- Total --}}
                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mt-3">
                                <label for="total" class="form-label">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror"
                                        placeholder="0.00" id="total" name="total" maxlength="50" min="0"
                                        step="0.01" value="{{ $purchase->total }}">
                                </div>
                                @error('total')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 text-center pt-3">
                                <button onclick="deshabilitar(this)"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a id="btnCancelar"
                                    class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/purchases">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Imagen Ampliada" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('voucher');
        const previewImage = document.getElementById('previewImage');

        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preview = document.getElementById('previewImage');
        const modalImage = document.getElementById('modalImage');

        preview.addEventListener('click', function() {
            modalImage.src = preview.src;
        });
    });
</script>
