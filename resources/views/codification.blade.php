

<script>
    // Encuentra el script por su "src" completo y lo elimina
    var script = document.querySelector('script[src="{{ asset('buildVelzon/js/app.js') }}"]');

    if (script) {
        script.remove();  // Elimina el script del DOM
        console.log('Script de app.js master eliminado correctamente');
    } else {
        console.log('No se encontró el de app.js master script');
    }
    

</script>

<script src="{{ URL::asset('buildVelzon/js/app.js') }}"></script>

<script>
    function isScriptLoaded(url) {
        // Seleccionar todos los elementos script en el documento
        const scripts = document.getElementsByTagName('script');

        // Recorrer los scripts para ver si alguno coincide con la URL proporcionada
        for (let i = 0; i < scripts.length; i++) {
            if (scripts[i].src.includes(url)) {
                return true; // El script ya está cargado
            }
        }
        return false; // El script no está cargado
    }

    // Ejemplo de uso


    // Verificar si el script ya está cargado antes de agregarlo
    if (!isScriptLoaded(scriptUrl)) {
        // Si no está cargado, crear un nuevo elemento script y agregarlo al DOM
        const script = document.createElement('script');
        script.src = scriptUrl + "?v=467867598789"; // Incluir el parámetro de versión
        document.head.appendChild(script);
        console.log("El script se ha cargado.");
    } else {
        console.log("El script ya estaba cargado.");
    }

</script>
<!-- <script src="{{ asset('vendor/laravel-crm/js/app.js') }}?v=467867598789"></script> -->
<script src="{{ asset('vendor/laravel-crm/libs/bootstrap-multiselect/bootstrap-multiselect.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="https://kit.fontawesome.com/489f6ee958.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        // Comprobar si existe la meta 'time_format' y obtener su contenido
        var timeFormat = $('meta[name="time_format"]').length > 0 ? $('meta[name="time_format"]').attr('content') : 'd/m/Y';

        // Obtener la fecha actual para usarla como predeterminada
        var currentDate = new Date();

        if (timeFormat) {
            // Inicializar datetimepicker para campos sin timepicker
            $(
                'input[name="birthday"], input[name="document_driving_license_country"], input[name="document_national_issued"], input[name="document_passport_issued"], input[name="document_driving_license_issued"], input[name="document_national_expiration"], input[name="document_passport_expiration"], input[name="document_driving_license_expiration"], input[name="expected_close"], input[name="issue_at"], input[name="expire_at"], input[name="issue_date"], input[name="due_date"], input[name="delivery_expected"], input[name="delivered_on"]'
            ).datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // Asegurarse de que el formato sea 'd/m/Y'
                defaultDate: currentDate,
                startDate: currentDate, // Establecer la fecha actual como fecha inicial
                onShow: function () {
                    this.setOptions({ defaultDate: currentDate });
                }
            });

            // Inicializar datetimepicker para campos con timepicker
            $(
                'input[name="noted_at"], input[name="due_at"], input[name="start_at"], input[name="finish_at"]'
            ).datetimepicker({
                timepicker: true,
                format: 'd/m/Y H:i', // Incluir tanto la fecha como la hora en el formato 'd/m/Y H:i'
                defaultDate: currentDate,
                startDate: currentDate, // Establecer la fecha actual como fecha inicial
                onShow: function () {
                    this.setOptions({ defaultDate: currentDate });
                }
            });
        }

        // Añadir eventos de clic y mouseover a las filas de la tabla con clase 'has-link'
        $('tr.has-link > td:not(.disable-link)').on({
            click: function () {
                var url = $(this).closest('tr').data('url');
                if (url) {
                    loadContent(url);
                    // Alternativamente, redirigir la página
                    // window.location = url;
                }
            },
            mouseover: function () {
                $(this).css('cursor', 'pointer');
            }
        });
    });
</script>
@stack('livewire-js')





