<script>
    // Mostrar las imágenes seleccionadas antes de enviar el formulario
    $(document).ready(function () {
        $('input[name="images[]"]').on('change', function () {
        let files = $(this)[0].files;
        let selectedImagesContainer = $('#selectedImagesContainer');

        // Vaciar el contenedor antes de agregar nuevas imágenes
        selectedImagesContainer.empty();

        for (let i = 0; i < files.length; i++) {
            let imageUrl = URL.createObjectURL(files[i]);
            let imageContainer = $('<div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 px-2 py-2 text-center"></div>');
            let imageElement = $('<img src="' + imageUrl + '" class="img-fluid rounded">');
            imageContainer.append(imageElement);
            selectedImagesContainer.append(imageContainer);
        }
    });
});
</script>