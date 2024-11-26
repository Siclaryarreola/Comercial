<script>
    // Manejar el envío del formulario de registro de usuario
    document.getElementById('addUserForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario tradicional
        const form = this;
        
        // Enviar datos al controlador usando Fetch API
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Usuario registrado exitosamente
                alert('Usuario registrado exitosamente');
                $('#addUserModal').modal('hide'); // Cerrar el modal
                location.reload(); // Recargar la página para ver los cambios
            } else {
                // Error al registrar usuario
                alert('Error al registrar usuario: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al procesar la solicitud.');
        });
    });
</script>
