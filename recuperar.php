<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body >
  
 

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                  <div class="card-header text-center"><h4>Recuperar cuenta</h4></div>
                    <div class="card-body">
                        <form action="" id="form-login" autocomplete="off">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control form-control-lg" id="email" autofocus required>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" id="recuperar">Siguiente</button>
                            </div>
                        </form>
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
            <h5 class="modal-title">Envio de codigo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                
            <div class="d-grid gap-2">
            <!-- <button class="btn btn-secondary btn-lg" data-metodo = "1" type="button"  id="Telefono">Enviar codigo al telefono</button> -->
            <button class="btn btn-secondary btn-lg" data-metodo = "2" type="button" id="Correo">Enviar codigo al correo    </button>
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">cerrar</button>
            <!-- <button type="button" class="btn btn-primary">Enviar codigo</button> -->
        </div>
        </div>
    </div>
  </div>

  <!-- MODAL VERIFICACION -->
  <div class="modal" tabindex="-1" id="modal-verificar">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Verificar codigo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

         <form action="">
           <div class="mb-3">
             <label for="email" class="form-label">Codigo verificacion</label>
             <input type="text" class="form-control form-control-lg" maxlength="6" id="in_codigo" autofocus required>
            </div>
          </form>     
            
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">cerrar</button> -->
        <button type="button" class="btn btn-primary" id="reenvio">reenviar el codigo</button>
        <button type="button" class="btn btn-primary" id="validar">Validar</button>
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