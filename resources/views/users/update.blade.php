{{-- Heredamos la estructura --}}
@extends('layouts.app')

{{-- Definimos el titulo --}}
@section('title', 'Usuario | Actualizar')

{{-- Definimos estilos propios --}}
@section('styles')
@endsection

{{-- Definimos el contenido --}}
@section('content')
    <h1 class="text-center">Actualizar Usuario</h1>
    <br>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="/users/update/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row m-auto col-xxl-8 col-xl-9 col-lg-10 col-md-11 col-sm-12">
                            {{-- Nombre --}}
                            <div class="col-md-6 my-2">
                                <label for="name" class="form-label fw-bold">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" maxlength="50" required>
                                @error('name')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Apellido --}}
                            <div class="col-md-6 my-2">
                                <label for="lastname" class="form-label fw-bold">Apellido:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    value="{{ old('lastname', $user->lastname) }}" maxlength="50" required>
                                @error('lastname')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-8 my-2">
                                <label for="email" class="form-label fw-bold">Email:</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" maxlength="255" readonly required>
                                @error('email')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Telefono --}}
                            <div class="col-md-4 my-2">
                                <label for="phone" class="form-label fw-bold">Tel&eacute;fono:</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}" maxlength="50" required>
                                @error('phone')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- agregar imagenes --}}
                            <div class="col-6 my-2">
                                <label for="profile_photo" class="form-label">Foto de perfil</label>
                                <input type="file" name="profile_photo" id="profile_photo"
                                    class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">

                                <!-- Aquí se agregarán las miniaturas de las imágenes seleccionadas -->
                                <div id="selectedImagesContainer" class="d-flex flex-wrap justify-content-center">
                                    <div id="selectedImages"
                                        class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 px-2 py-2 text-center">
                                        <img id="previewImage" src="{{ $user->profile_photo }}" alt="Imagen Actual"
                                            class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>

                            {{-- Direccion --}}
                            <div class="col-6 my-2">
                                <label for="address" class="form-label">Dirección:</label>
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="6"
                                    required autocomplete="address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if (Auth::user()->role->name === 'admin')
                                {{-- Rol --}}
                                <div class="col-md-12 mb-3">
                                    <label for="idRole" class="form-label fw-bold">Rol:</label>
                                    <select name="idRole" id="idRole" class="form-control" required>
                                        <option value="">-- Seleccionar Rol --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->idRole }}"
                                                {{ $user->idRole == $role->idRole ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idRole')
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif

                            {{-- Botones --}}
                            <div class="col-12 text-center pt-3">
                                <button type="submit"
                                    class="mt-2 btn btn-primary btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5">
                                    Actualizar
                                </button>
                                <a class="mt-2 btn btn-dark btn-md col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-5"
                                    href="/users">Cancelar</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('profile_photo');
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
