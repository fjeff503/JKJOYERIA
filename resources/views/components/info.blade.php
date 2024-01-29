    {{-- Mensaje de exito --}}
    @if (session('info'))
        <script>
            Swal.fire({
                padding: '2rem',
                icon: 'info',
                title: '¡Éxito!',
                text: '{{ session('info') }}'
            });
        </script>
    @endif
