<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!--IMPORTACIONES DE CSS-->
    <link rel="stylesheet" href="{{ asset('melody/vendors/iconfonts/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('melody/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('melody/vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="{{ asset('melody/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.16/dist/sweetalert2.min.css
" rel="stylesheet">

    <!-- INCLUIR USO DE MIS ARCHIVOS CSS -->
    @yield('styles')

    <!--ICONO-->
    <link rel="shortcut icon" href="{{ asset('melody/images/logo-mini.svg') }}">
    <!-- Incluye los archivos de inputmask -->
    <script src="{{ asset('InputMask/inputmask.min.js') }}"></script>

    <!-- Agrega un script para inicializar la máscara en el campo de teléfono -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Inputmask({
                mask: '9999-9999',
                placeholder: ''
            }).mask('#phone');
            Inputmask({
                mask: '9999-9999',
                placeholder: ''
            }).mask('#whatsapp');
        });
    </script>
</head>

<!-- CUERPO DE LA PAGINA -->

<body>
    <!-- DIV CONTENEDOR -->
    <div class="container-scroller">
        <!-- INCLUIMOS EL COMPONENETE DEL MENU SUPERIOR -->
        @include('components.menuSuperior')

        <!-- CONTENIDO DE LA PAGINA -->
        <div class="container-fluid page-body-wrapper">
            <!-- INCLUIMOS EL COMPONENETE DEL MENU IZQUIERDO -->
            @include('components.menuLateral')

            <!-- ABRIR MENU OCULTO -->
            @yield('preference')

            <!-- CONTENDIO PRINCIPAL -->
            <div class="main-panel p-4">
                <!--CONTENIDO DEL MENU OCULTO -->
                @yield('content')
                <!-- FIN CONTENDIO PRINCIPAL -->
            </div>
            <!-- FIN CONTENIDO DE LA PAGINA -->
        </div>
        <!-- INCLUIMOS EL COMPONENETE DEL MENU IZQUIERDO -->
        @include('components.footer')
        <!-- FIN DIV CONTENEDOR -->
    </div>
    <!-- FIN CUERPO DE LA PAGINA -->
</body>

<!-- plugins:js -->
<script src="{{ asset('melody/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('melody/vendors/js/vendor.bundle.addons.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('melody/js/off-canvas.js') }}"></script>
<script src="{{ asset('melody/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('melody/js/misc.js') }}"></script>
<script src="{{ asset('melody/js/settings.js') }}"></script>

<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('melody/js/dashboard.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- End custom js for this page-->
@yield('scripts')

</html>
