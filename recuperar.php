<!doctype html>
<html lang="es">

<head>
  <title>Recuperar Contraseña</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body >
  
<div class="container-fluid vh-100 d-flex align-items-center">
  <div class="card mx-auto" style="max-width: 850px;">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="./test/modalCONTRASEÑA.jpeg" style="width: 300%; height: 100%;" class="img-fluid" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h2 class="card-title">Recuperar Contraseña</h2>
          <hr>
          <p class="card-text">Ingrese su correo electrónico, así ubicaremos su registro y enviaremos el código de recuperación.</p>
          <div class="col-auto">
            <label class="visually-hidden" for="autoSizingInputGroup"></label>
            <div class="input-group">
              <div class="input-group-text">@</div>
              <input type="email" id="email" class="form-control" id="autoSizingInputGroup" placeholder="Correo Electrónico" autofocus required>
            </div>
          </div>
        </div>
        <div class="mt-auto card-footer d-flex justify-content-end">
          <button type="button" class="btn btn-primary float-end" id="recuperar">Siguiente</button>
        </div>
      </div>
    </div>
  </div>
</div>


 


  <!-- Inicio de MODAL -->

  <div class="modal" tabindex="-1" id="modal-seleccion">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-shield-lock-fill"></i> Enviar código de recuperación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                
            <div class="d-grid gap-2">
            <!-- <button class="btn btn-secondary btn-lg" data-metodo = "1" type="button"  id="Telefono">Enviar codigo al telefono</button> -->
            <button class="btn btn-primary btn-lg text-light" data-metodo = "2" type="button" id="Correo">Enviar código</button>
            <p id="mensaje-enviando" class="d-none"><i class="bi bi-hourglass"></i> Estamos enviando el código...</p>
            <p><i class="bi bi-hand-index-thumb"></i>  Luego de enviar el código, porfavor revise la bandeja de entrada y la carpeta Spam de su correo electrónico.</p>
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
            <!-- <button type="button" class="btn btn-primary">Enviar codigo</button> -->
        </div>
        </div>
    </div>
  </div>

  <!-- MODAL VERIFICACION -->
  <div class="modal" tabindex="-1" id="modal-verificar" >
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal">
    <div class="modal-content">
      <div class="modal-header"  style="background-color: #4285f4;">
        <h5 class="modal-title  text-light">Verificar código</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

         <form action="">
           <div class="mb-3">
             <label for="email" class="form-label">Ingrese el código envíado a su correo electrónico:</label>
             <input type="text" class="form-control form-control-lg" placeholder="_ _ _ _ _ _" maxlength="6" id="in_codigo" autofocus required>
            </div>
          </form>     
            
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">cerrar</button> -->
        <button type="button" class="btn btn-success" id="validar">Validar Código</button>
        <button type="button" class="btn btn-secondary" id="reenvio">Reenviar código</button>
      </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    document.addEventListener("DOMContentLoaded",() => {
    function $(id){return document.querySelector(id)}
        var modalSeleccion = new bootstrap.Modal($('#modal-seleccion'));
        var modalVerificar = new bootstrap.Modal($('#modal-verificar'));


        
        function traer_usuario(){
            const parametros= new FormData();
            parametros.append("operacion" ,"recuperar_usuario");          
            parametros.append("email"     ,$("#email").value);            

            fetch(`./controllers/usuario.controller.php`,{
            method: "POST",
            body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos =>  {
            console.log(datos);
            console.log(datos.idusuario);

            if(datos){
                
                // $('#Telefono').setAttribute('data-userid',datos.idusuario)
                $('#Correo').setAttribute('data-userid',datos.idusuario)
                $('#Correo').setAttribute('data-direccion',datos.email)
                modalSeleccion.show();
                
            }else{
                alert("No hay ningun usuario con ese email");
            }
            })
            .catch(e => {
            console.error(e);
            });
        }
        
        function enviar_codigo( usuario, metodo, direccion ){

          const parametros= new FormData();
          parametros.append("operacion" ,"generar_codigo");          
          parametros.append("idusuario"     ,usuario);            
          parametros.append("metodo"        ,metodo);            
          parametros.append("direccion"     ,direccion);          

          fetch(`./controllers/usuario.controller.php`,{
          method: "POST",
          body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos =>{
            console.log(datos);
            if(datos){

              $('#reenvio').setAttribute('data-userid',datos.idusuario)
              $('#validar').setAttribute('data-userid',datos.idusuario)
              $('#reenvio').setAttribute('data-direccion',direccion)
              $('#reenvio').setAttribute('data-metodo',metodo)
              modalVerificar.show();
              
            }else{
              console.log("hubo un error")
            }
          })
          .catch(e => {
          console.error(e);
          });
        }

        function verificar_codigo( usuario){

          const parametros= new FormData();
          parametros.append("operacion"     ,"verificar_codigo");          
          parametros.append("idusuario"     ,usuario);                    


          fetch(`./controllers/usuario.controller.php`,{
          method: "POST",
          body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos =>{ 

            console.log(datos);
            let codigo =  datos.codigo;
            let idusuario =  datos.idusuario;
            // console.log(typeof algo);
            // console.log(typeof $("#in_codigo").value);

            if(codigo == $("#in_codigo").value){
              window.location.href = `./modificar.php?idusuario=${idusuario}`;
            }else{
              console.log("datos incorrectos");
              
            }
            

          })
          .catch(e => {
          console.error(e);
          });
        }


        $('#recuperar').addEventListener('click', function() {
        traer_usuario();
        });

        $('#Correo').addEventListener('click', function(){
          usuario   = $('#Correo').getAttribute('data-userid');
          metodo    = $('#Correo').getAttribute('data-metodo');
          direccion = $('#Correo').getAttribute('data-direccion');
          enviar_codigo(usuario, metodo, direccion);
       });

       $('#validar').addEventListener('click', function() {
          usuario = $('#reenvio').getAttribute('data-userid');
          verificar_codigo(usuario);
        // var confirmacion = confirm("¿Estás seguro de que deseas continuar?");
        // if (confirmacion) {

        //   usuario = $('#reenvio').getAttribute('data-userid');
        //   verificar_codigo(usuario);

        // } else {
        //   alert("cancelado.");
        // }
      });


    });
  </script>

</body>

</html>