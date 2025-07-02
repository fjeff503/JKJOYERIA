@extends('layouts.login')

{{-- Definimos el titulo --}}
@section('title', 'Registro')

@section('content')
    <div class="container text-white">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <h3 class="text-center mb-3">Registra tu cuenta</h3>
                    <br>
                    <div class="row">
                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="name" class="col-form-label text-md-end fw-bold">Nombre:</label>
                            <input id="name" type="text" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="col-md-6">
                            <label for="lastname" class="col-form-label text-md-end fw-bold">Apellido:</label>
                            <input id="lastname" type="text" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('lastname') is-invalid @enderror"
                                name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                            @error('lastname')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-8">
                            <label for="email" class="col-form-label text-md-end fw-bold">Correo Electrónico:</label>
                            <input id="email" type="email" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Telefono --}}
                        <div class="col-md-4">
                            <label for="phone" class="col-form-label text-md-end fw-bold">Tel&eacute;fono:</label>
                            <input id="phone" type="tel" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                            @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        {{-- Foto de Perfil --}}
                        <div class="col-6 my-2">
                            <label for="profile_photo" class="form-label">Foto de perfil</label>
                            <input type="file" style="background-color: #1c2433;" name="profile_photo" id="profile_photo"
                                class="form-control text-white border-light @error('profile_photo') is-invalid @enderror">

                            <!-- Aquí se agregarán las miniaturas de las imágenes seleccionadas -->
                            <div id="selectedImagesContainer" class="d-flex flex-wrap justify-content-center">
                                <div id="selectedImages"
                                    class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 px-2 py-2 text-center">
                                    <img id="previewImage" src="" alt="Imagen Actual"
                                        class="img-fluid rounded d-none">
                                </div>
                            </div>
                        </div>


                        {{-- Direccion --}}
                        <div class="col-6 my-2">
                            <label for="address" class="form-label text-md-end fw-bold">Dirección:</label>
                            <textarea id="address" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('address') is-invalid @enderror" name="address" rows="6"
                                required autocomplete="address">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="col-form-label text-md-end fw-bold">Contraseña:</label>
                            <input id="password" type="password" style="background-color: #1c2433;"
                                class="form-control text-white border-light @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirmar Password --}}
                        <div class="col-md-6">
                            <label for="password-confirm" class="col-form-label text-md-end fw-bold">Confirmar
                                Contraseña:</label>
                            <input id="password-confirm" type="password" style="background-color: #1c2433;"
                                class="form-control text-white border-light" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                    </div>
                    {{-- Botón --}}
                    <div class="m-3 text-center">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-lg text-white col-8 mr-3"
                                style="background-color: #615fff; border-color: #615fff;">
                                Registrarse
                            </button>

                            <a href="{{ route('login') }}" class="btn btn-lg text-white col-4"
                                style="background-color: #6c757d; border-color: #6c757d;">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
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
                        previewImage.classList.remove('d-none'); // Mostramos la imagen
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.classList.add('d-none'); // Ocultamos si no es imagen o se borra
                    previewImage.src = '';
                }
            });
        });
    </script>
