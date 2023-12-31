<?php

if(isset($_SESSION["status"]) && $_SESSION["status"]){

  header("Location:./views/sectores/inicio.php");
}
?>
<!doctype html>
<html lang="es">

<head>
  <title>LOGIN</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/login.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body>

<div class="container-fluid">

  <section class="text-center">

    <!-- IMAGEN SUPERIOR  -->
    <div class="p-5 bg-image" style="background-image: url('./images/logo/reparacionBANNER.jpeg');
        height: 500px;
        background-position: center;
        background-size: cover;">
    </div>

    <div class="card mx-4 mx-md-5 shadow-5-strong" 
        style="margin-top: -100px;
          background: hsla(0, 0%, 100%, 0.8);
          backdrop-filter: blur(30px);">

      <div class="card-body py-5 px-md-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <h2 class="fw-bold mb-5">INICIO DE SESIÓN</h2>
              
            <!-- INICIO DEL FORMULARIO -->


            <form action="" id="form-login">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input type="email" id="email" class="form-control" autofocus required />
                      <label class="form-label" for="email">E-Mail</label>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input type="password" id="claveacceso" class="form-control" required />
                      <label class="form-label" for="claveacceso">Contraseña</label>
                    </div>
                  </div>
                </div>
              </div>

                <!-- BOTÓN de inicio de sesión -->
              <button type="submit" class="btn btn-primary btn-btn-block mb-4" id="acceder">Acceder</button>

              <!-- Enlace -->
              <div class="form-check d-flex justify-content-center mb-4">
                <a href="./recuperar.php" class="btn btn-link">
                Olvidé mi contraseña <i class="bi bi-key"></i>
                </svg>
                </a>
              </div>

            <!-- </form> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>




  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

</body>

<script>
  function $(id) {
    return document.querySelector(id);
  }
  const tiempo = 3;

  $("#form-login").addEventListener("submit", (event) => {
    event.preventDefault();

      const parametros = new FormData();
      parametros.append("operacion", "login_usuario");
      parametros.append("email", $("#email").value);
      parametros.append("claveacceso", $("#claveacceso").value);

      fetch(`./controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
          console.log(datos);

          if (datos.acceso === true) {
            toast("Acceso correcto");
            setTimeout(() => { //Una pequeña pausa para que se muestre el SweetAlert
              window.location.href = './views/sectores/sectores.php';
            }, 1000);
          } else {
            // SweetAlert
            if (datos.mensaje === "El correo no existe") {
              Swal.fire({
                icon: 'error',
                title: 'Acceso incorrecto',
                text: 'El correo ingresado no existe',
                confirmButtonColor: '#2E86C1',
                confirmButtonText: 'Aceptar',
                footer: 'Verifique sus credenciales de registro',
                timerProgressBar: true,
                timer: (tiempo * 1000)
              });
            } else if (datos.mensaje === "La contraseña es incorrecta") {
              Swal.fire({
                icon: 'error',
                title: 'Acceso incorrecto',
                text: 'La contraseña es incorrecta',
                confirmButtonColor: '#2E86C1',
                confirmButtonText: 'Aceptar',
                footer: 'Verifique sus credenciales de registro',
                timerProgressBar: true,
                timer: (tiempo * 1000)
              });
            } else {
              alert(datos.mensaje);
            }
          }
        })
        .catch(e => {
          console.error(e);
        });
    });
  

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
</script>

</html>