{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Ventas | Registrar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

<style>
    .modal-dialog {
        max-width: 80% !important;
        /* Ajusta el porcentaje a lo que necesites */
        width: 80% !important;
    }
</style>

{{-- Definimos el contenido --}}
@section('content')
    {{-- Cuerpo de mi index --}}
    <h1 class="text-center">Registrar Venta</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    {{-- CUERPO PARA CREAR --}}
                    <form id="Formulario" action="/sales/store" method="POST">
                        @csrf
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            {{-- Cliente --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idClient" class="form-label">Cliente:</label>
                                <input type="hidden" id="idClient" name="idClient" value="{{ old('idClient') }}">
                                <div class="input-group">
                                    <input type="text" id="nombreCliente" name="nombreCliente" class="form-control"
                                        placeholder="Selecciona un cliente" readonly value="{{ old('nombreCliente') }}"
                                        data-bs-toggle="modal" data-bs-target="#clientesModal" style="cursor:pointer;">
                                </div>
                                @error('idClient')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Punto de Entrega --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idDeliveryPoint" class="form-label">Punto de Entrega:</label>
                                <input type="hidden" id="idDeliveryPoint" name="idDeliveryPoint"
                                    value="{{ old('idDeliveryPoint') }}">

                                <div class="input-group">
                                    <input type="text" id="nombreDeliveryPoint" name="nombreDeliveryPoint"
                                        class="form-control" placeholder="Selecciona un Punto de Entrega" readonly
                                        value="{{ old('nombreDeliveryPoint') }}" data-bs-toggle="modal"
                                        data-bs-target="#deliveryPointsModal" style="cursor:pointer;">
                                </div>

                                @error('idDeliveryPoint')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Estado de Paquete --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idPackageState" class="form-label">Estado de Paquete:</label>
                                <select name="idPackageState" id="idPackageState" class="form-control"
                                    style="height: calc(3rem);">
                                    @foreach ($package_states as $item)
                                        <option value="{{ $item->idPackageState }}"
                                            @if (old('idPackageState') == $item->idPackageState) selected @endif>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idPackageState')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Estado de Pago --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                                <label for="idPaymentState" class="form-label">Estado de Pago:</label>
                                <select name="idPaymentState" id="idPaymentState" class="form-control"
                                    style="height: calc(3rem);">
                                    @foreach ($payment_states as $item)
                                        <option value="{{ $item->idPaymentState }}"
                                            @if (old('idPaymentState') == $item->idPaymentState) selected @endif>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idPaymentState')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Descripcion --}}
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                                <label for="description" class="form-label">Comentarios:</label>
                                <textarea class="form-control" placeholder="Comentarios" id="description" name="description" maxlength="100">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                                            <th>Precio</th>
                                            <th>Descuento</th>
                                            <th>Cantidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            {{-- Campo oculto para enviar los productos como JSON --}}
                            <input type="hidden" name="detalle" id="detalle" value="{{ old('detalle') }}">
                            @error('detalle')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- Cerramos el detalleCompra --}}

                            <div class="col-12 text-center pt-3">
                                <button onclick="deshabilitar(this)"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">Guardar</button>
                                <a id="btnCancelar"
                                    class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/sales">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Clientes --}}
    <div class="modal fade" id="clientesModal" tabindex="-1" aria-labelledby="clientesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100 text-center" id="clientesModalLabel">Selecciona un Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive pt-4">
                        <table id="tablaClientes" class="table table-hover table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Whatsapp</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($clients as $cliente)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $cliente->name }}</td>
                                        <td>{{ $cliente->phone }}</td>
                                        <td>{{ $cliente->whatsapp }}</td>
                                        <td>
                                            <button class="btn btn-success seleccionar-cliente p-3"
                                                data-id="{{ $cliente->idClient }}" data-name="{{ $cliente->name }}">
                                                Seleccionar
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Puntos de Entrega --}}
    <div class="modal fade" id="deliveryPointsModal" tabindex="-1" aria-labelledby="deliveryPointsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100 text-center" id="deliveryPointsModalLabel">Selecciona un Punto de Entrega
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive pt-4">
                        <table id="tablaDeliveryPoints" class="table table-hover table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Encomendista</th>
                                    <th>D&iacute;a</th>
                                    <th>Hora</th>
                                    <th>Descripc&oacute;n</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($delivery_points as $deliveryPoint)
                                    <tr>
                                        <td>{{ $deliveryPoint->name }}</td>
                                        <td>{{ $deliveryPoint->parcel }}</td>
                                        <td>{{ $deliveryPoint->day }}</td>
                                        <td>{{ $deliveryPoint->hour }}</td>
                                        <td>{{ $deliveryPoint->description }}</td>
                                        <td>
                                            <button class="btn btn-success p-3 seleccionar-deliveryPoint"
                                                data-id="{{ $deliveryPoint->idDeliveryPoint }}"
                                                data-name="{{ $deliveryPoint->name }}">
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Incluimos el script para desactivar los botones --}}
@include('components.procesando')

<!-- jQuery -->
<script src="{{ asset('jQuery/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
@include('components.dataTable', ['tablaId' => 'tablaClientes'])
@include('components.dataTable', ['tablaId' => 'tablaDeliveryPoints'])

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        function agregarProducto(producto) {
            const existente = productos.find(p => p.idProduct === producto.idProduct);
            if (existente) {
                existente.cantidad++;
                existente.subtotal = (existente.sellPrice - (existente.discount || 0)) * existente.cantidad;
            } else {
                if (producto.stock <= 0) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: 'error',
                        title: `Este producto no tiene unidades disponibles.`,
                        showConfirmButton: true,
                    });
                    return;
                }
                productos.push({
                    idProduct: producto.idProduct,
                    codeProduct: producto.codeProduct,
                    name: producto.name,
                    stock: producto.stock,
                    sellPrice: parseFloat(producto.sellPrice),
                    discount: 0,
                    cantidad: 1,
                    subtotal: parseFloat(producto.sellPrice)
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
                    <td>$${p.sellPrice.toFixed(2)}</td>
                    <td><div class="input-group"><span class="input-group-text">$</span><input type="number" value="${p.discount}" min="0" step="0.01"
                        onchange="actualizarCampo(${index}, 'discount', this.value)" class="form-control"></div></td>
                    <td><input type="number" value="${p.cantidad}" min="1" max="${p.stock}"
                        onchange="actualizarCampo(${index}, 'cantidad', this.value)" class="form-control"></td>
                    <td><button type="button" onclick="eliminarProducto(${index})" class="btn btn-danger btn-sm">Eliminar</button></td>
                </tr>
            `;
            });

            document.getElementById('detalle').value = JSON.stringify(productos);
            actualizarTotal();
        }

        window.actualizarCampo = function(index, campo, valor) {
            let nuevoValor = parseFloat(valor);
            if (campo === 'cantidad') {
                const maxStock = productos[index].stock || 0;
                if (nuevoValor > maxStock) {

                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: 'error',
                        title: `Solo hay ${maxStock} unidades disponibles en stock.`,
                        showConfirmButton: true,
                    });
                    nuevoValor = maxStock;
                } else if (nuevoValor < 1) {
                    nuevoValor = 1; // mínimo 1
                }
            }
            productos[index][campo] = nuevoValor;
            const precioReal = productos[index].sellPrice - (productos[index].discount || 0);
            productos[index].subtotal = precioReal * productos[index].cantidad;
            renderTabla();
        }

        window.eliminarProducto = function(index) {
            productos.splice(index, 1);
            renderTabla();
        }

        function actualizarTotal() {
            const total = productos.reduce((sum, p) => {
                const precioFinal = p.sellPrice - (p.discount || 0);
                return sum + (precioFinal * p.cantidad);
            }, 0);
            document.getElementById('total').value = total.toFixed(2);
        }
    });


    $(document).ready(function() {
        // Evento para seleccionar cliente
        $('#tablaClientes').on('click', '.seleccionar-cliente', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#idClient').val(id);
            $('#nombreCliente').val(name);

            const modalEl = document.getElementById('clientesModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });

        // Evento para seleccionar punto de entrega
        $('#tablaDeliveryPoints').on('click', '.seleccionar-deliveryPoint', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            // Actualiza el input hidden con el id seleccionado
            $('#idDeliveryPoint').val(id);

            // Actualiza el input visible con el nombre
            $('#nombreDeliveryPoint').val(name);

            // Cierra el modal
            const modalEl = document.getElementById('deliveryPointsModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });
    });
</script>
