    {{-- Mensaje de exito --}}
    @if (session('error'))
        <script>
            Swal.fire({
                padding: '2rem',
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}'
            });
        </script>
    @endif