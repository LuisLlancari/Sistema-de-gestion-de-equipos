        /* SWEET ALERT */
        /**
         * Mensaje de exito
         */
        function toast(mensaje) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                icon: 'success',
                title: mensaje
            })
        }

        /**
         * Alerta de error
         */
        function alertError(mensaje = "",razon = "",sugerencia = ""){
            Swal.fire({
                icon: 'error',
                title: mensaje,
                text: razon,
                confirmButtonColor: '#2E86C1',
                confirmButtonText: 'Aceptar',
                footer: sugerencia,
                timerProgressBar: true,
                timer: 1000
              });
        }

        /**
         * Pregintar
         */
        function mostrarPregunta(titulo, mensaje) {
            return Swal.fire({
                title: titulo,
                text: mensaje,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#2E86C1',
                cancelButtonColor: '#797D7F',
                footer: 'SISCOMPU'
            }).then((result) => {
                return result;
            });
        }
