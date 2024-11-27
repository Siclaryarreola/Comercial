<<<<<<< HEAD
<script> 
=======
<script>
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Usuario registrado exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    $('#addUserModal').modal('hide'); // Cerrar el modal
                    location.reload(); // Recargar la página para ver los cambios
                });
            } else {
                // Error al registrar usuario
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar usuario: ' + data.message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
=======
                alert('Usuario registrado exitosamente');
                $('#addUserModal').modal('hide'); // Cerrar el modal
                location.reload(); // Recargar la página para ver los cambios
            } else {
                // Error al registrar usuario
                alert('Error al registrar usuario: ' + data.message);
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            }
        })
        .catch(error => {
            console.error('Error:', error);
<<<<<<< HEAD
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
=======
            alert('Hubo un error al procesar la solicitud.');
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        });
    });
</script>
