        /* SWEET ALERT */
        /**
         * Mensaje de exito
         */
        function toast(mensaje) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
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
         * Preguntar
         */
        function mostrarPregunta(titulo, mensaje,funcion) {
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

                if(result.isConfirmed){
                    if(typeof funcion == 'function'){
                        funcion();
                    }
                }

                return result;
            });
        }
