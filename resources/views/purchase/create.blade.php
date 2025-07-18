{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Compras | Registrar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Registrar Compra</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form id="Formulario" action="/purchases/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            {{-- Proveedor --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idProvider" class="form-label">Proveedor:</label>
                                <select name="idProvider" id="idProvider" class="form-control" style="height: calc(3rem);">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($providers as $item)
                                        <option value="{{ $item->idProvider }}"
                                            @if (old('idProvider') == $item->idProvider) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('idProvider')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Voucher --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3 d-flex align-items-center">
                                <div class="col-10">
                                    <label for="voucher" class="form-label">Voucher</label>
                                    <input type="file" name="voucher" id="voucher"
                                        class="form-control @error('voucher') is-invalid @enderror">
                                </div>
                                <img id="previewImage" src="" alt="Imagen Actual" class="ml-2 mr-0 d-none"
                                    style="width: 4.5rem; height: 4.5rem; cursor: pointer;" data-bs-toggle="modal"
                                    data-bs-target="#imageModal">
                            </div>


                            {{-- Vamos con el detalleCompra --}}
                            {{-- Buscar producto por código --}}
                            <div class="col-10 mt-4">
                                <label for="codigoProducto" class="form-label">Agregar producto por código:</label>
                                <input type="text" id="codigoProducto" class="form-control"
                                    placeholder="Código del producto">
                            </div>

                            {{-- Total --}}
                            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mt-4">
                                <label for="total" class="form-label">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror"
                                        placeholder="0.00" id="total" name="total" maxlength="50" min="0"
                                        step="0.01" value="{{ old('total') }}">
                                </div>
                                @error('total')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Tabla para mostrar productos agregados --}}
                            <div class="col-12 mt-3">
                                <table class="table table-bordered" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Precio Venta</th>
                                            <th>Precio Compra</th>
                                            <th>Cantidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            {{-- Campo oculto para enviar los productos como JSON --}}
                            <input type="hidden" name="detalle" id="detalle" value="{{ old('detalle') }}">
                            {{-- Cerramos el detalleCompra --}}

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
        <div class="modal-dialog modal-dialog-centered modal-md" id="modalDialog">
            <div class="modal-content">
                <div class="modal-body position-relative text-center">
                    <!-- Botón de lupa interactivo -->
                    <button id="zoomButton" class="btn btn-light position-absolute"
                        style="top: 10px; right: 10px; z-index: 1050;" onclick="toggleModalSize()">
                        <i id="zoomIcon" class="fas fa-search-plus"></i>
                    </button>

                    <!-- Imagen -->
                    <img id="modalImage" src="" alt="Imagen Ampliada" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Incluimos el script para desactivar los botones --}}
@include('components.procesando')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        const inputVoucher = document.getElementById('voucher');
        const previewImage = document.getElementById('previewImage');
        const modalImage = document.getElementById('modalImage');
        const inputCodigo = document.getElementById('codigoProducto');
        const form = document.getElementById('Formulario');
        let productos = [];

        //rellenar la lista en caso de actualizar la pagina
        const detalleInput = document.getElementById('detalle');
        if (detalleInput && detalleInput.value) {
            try {
                productos = JSON.parse(detalleInput.value);
                renderTabla();
            } catch (error) {
                productos = [];
            }
        }

        // Mostrar preview de imagen cargada
        if (inputVoucher) {
            inputVoucher.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.classList.add('d-none');
                    previewImage.src = '';
                }
            });
        }

        // Abrir imagen en modal al hacer clic en el preview
        if (previewImage) {
            previewImage.addEventListener('click', function() {
                if (previewImage.src) {
                    modalImage.src = previewImage.src;
                }
            });
        }

        // Listener para agregar producto por código cuando presionas Enter
        if (inputCodigo) {
            inputCodigo.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();

                    const codigo = this.value.trim();
                    if (!codigo) return;

                    fetch(`/products/buscar/${encodeURIComponent(codigo)}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error en la respuesta del servidor');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                agregarProducto(data.producto);
                                this.value = '';
                            } else {
                                alert('Producto no encontrado');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocurrió un error al buscar el producto.');
                        });
                }
            });
        }

        // Evitar enviar formulario si el foco está en el input codigoProducto
        if (form) {
            form.addEventListener('submit', function(e) {
                if (document.activeElement && document.activeElement.id === 'codigoProducto') {
                    e.preventDefault();
                    alert(
                        'Por favor usa Enter para agregar el producto, no para enviar el formulario.'
                    );
                }
            });
        }

        // Función para agregar un producto a la lista
        function agregarProducto(producto) {
            const existente = productos.find(p => p.idProduct === producto.idProduct);
            if (existente) {
                existente.cantidad++;
                existente.subtotal = existente.buyPrice * existente.cantidad;
            } else {
                productos.push({
                    idProduct: producto.idProduct,
                    codeProduct: producto.codeProduct,
                    name: producto.name,
                    sellPrice: parseFloat(producto.sellPrice),
                    buyPrice: parseFloat(producto.buyPrice), // editable por el usuario
                    cantidad: 1,
                    subtotal: parseFloat(producto.buyPrice)
                });
            }
            renderTabla();
        }

        function renderTabla() {
            const tbody = document.querySelector('#tablaProductos tbody');
            tbody.innerHTML = '';

            productos.forEach((p, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${p.idProduct}</td>
                        <td>${p.name}</td>
                        <td>$${(parseFloat(p.sellPrice) || 0).toFixed(2)}</td>
                        <td><input type="number" value="${p.buyPrice}" min="0" step="0.01"
                            onchange="actualizarCampo(${index}, 'buyPrice', this.value)" class="form-control"></td>
                        <td><input type="number" value="${p.cantidad}" min="1"
                            onchange="actualizarCampo(${index}, 'cantidad', this.value)" class="form-control"></td>
                        <td><button type="button" onclick="eliminarProducto(${index})" class="btn btn-danger btn-sm">Eliminar</button></td>
                    </tr>
                `;
            });

            document.getElementById('detalle').value = JSON.stringify(productos);
            actualizarTotal();
        }

        // Para que estas funciones puedan ser llamadas desde los inputs y botones que generas dinámicamente,
        // las agregamos al objeto window:
        window.actualizarCampo = function(index, campo, valor) {
            productos[index][campo] = parseFloat(valor);
            productos[index].subtotal = productos[index].buyPrice * productos[index].cantidad;
            renderTabla();
        }

        window.eliminarProducto = function(index) {
            productos.splice(index, 1);
            renderTabla();
        }

        function actualizarTotal() {
            let total = productos.reduce((sum, p) => sum + (p.buyPrice * p.cantidad), 0);
            document.getElementById('total').value = total.toFixed(2);
        }
    });

    // Función para agrandar o reducir modal de imagen
    function toggleModalSize() {
        const dialog = document.getElementById('modalDialog');
        const icon = document.getElementById('zoomIcon');

        const isMd = dialog.classList.contains('modal-md');

        dialog.classList.toggle('modal-md', !isMd);
        dialog.classList.toggle('modal-lg', isMd);

        icon.classList.remove('fa-search-plus', 'fa-search-minus');
        icon.classList.add(isMd ? 'fa-search-minus' : 'fa-search-plus');
    }
</script>
