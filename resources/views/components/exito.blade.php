    {{-- Mensaje de exito --}}
    @if (session('success'))
        <script>
            Swal.fire({
                padding: '2rem',
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}'
            });
        </script>
    @endif
