<script>
    destroy = function(e, mensaje1, mensaje2, mensaje3) {
        let url = e.getAttribute('url')
        let token = e.getAttribute('token')
        Swal.fire({
            padding: '2rem',
            icon: 'question',
            title: '¿Desea continuar?',
            text: mensaje1,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si'
        }).then((res) => {
            if (res.isConfirmed) {
                const request = new XMLHttpRequest();
                request.open('delete', url);
                request.setRequestHeader('X-CSRF-TOKEN', token);
                request.onload = () => {
                    if (request.status == 200) {
                        e.closest('tr').remove()
                        Swal.fire({
                            padding: '2rem',
                            icon: 'success',
                            title: '¡Éxito!',
                            text: mensaje2,
                        })
                    } else {
                        Swal.fire({
                            padding: '2rem',
                            icon: 'error',
                            title: '¡Error!',
                            text: mensaje3,
                        })
                    }
                }
                request.onerror = err => rejects(err);
                request.send();
            }
        })
    }
</script>
