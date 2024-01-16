<script>
    function deshabilitar(button){
        // Cambia el texto del botón
        button.innerHTML = 'Procesando...';
        // Deshabilita el botón
        button.disabled = true;
        // Oculta el botón "Cancelar"
        document.getElementById('btnCancelar').style.display = 'none';
        // Envía el formulario
        document.getElementById('Formulario').submit();
    }
</script>