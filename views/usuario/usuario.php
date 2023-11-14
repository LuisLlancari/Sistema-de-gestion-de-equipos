<!doctype html>
<html lang="es">

<head>
  <title>Lista de Usuarios</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
<div class = "container mt-3">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">

        <div class="mb-3">
         <h1>Lista de trabajdores</h1>
         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-registrar">Agregar usuario</button>
        </div>
      </div>
      <div class="col-md-4"></div>
    </div>
  <div>

  <div class="container mx-3">
    <div class="row row-cols-1 row-cols-md-3 g-4" id="contenerdor-cards">
        
    <!-- <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
            <img src="..." class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Nombre trabajador</h5>
                <p class="card-text">correo</p>
                <p class="card-text">cargo</p>
                <div class="container">
                <button type="button" class="btn btn-sm btn-warning">Editar</button>
                <button type="button" class="btn btn-sm btn-danger">Eliminar</button>
                </div>
            </div>
            </div>
        </div>
    </div>   -->



    
    </div>
  </div>
  <!-- INICIO DEL MODAL TREGISTRAR USUARIO -->

    <div class="modal fade" id="modal-registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar usuario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" autocomplete="off" id="form-usuario">
            <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="apellidos" class="form-label">Apellidos</label>
                  <input type="text" class="form-control" id="apellidos" required>
                  </select>
                </div>
                  <div class="col-md-6 mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nombres" required>
                  </div>
                </div>

              
                <div class="mb-3">
                  <label for="rol" class="form-label">Seleccione su rol</label>
                  <select name="" id="rol" class="form-select" required>
                  <option value="">Seleccion:</option>
                  <option value="Administrador">Administrador:</option>
                  <option value="Invitado">Invitado:</option>
                </select>
                </div>
              

                <div class="mb-3">
                  <label for="Email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" required>
                </div>

                <div class="mb-3">
                  <label for="contraseña" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="contraseña" required>
                </div>

                <d class="md-3">
                  <label for="fotografia" class="form-label">Fotografia</label>
                  <input type="file" class="form-control" id="avatar" accept=".jpg">
              </d iv>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrar" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="registrar" >Registrar</button>
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
      const cuerpo = document.querySelector("#contenerdor-cards");
      function $(id){return document.querySelector(id)};  


        function listar_usuarios(){
          const parametros = new FormData();
          parametros.append("operacion","listar_usuario");

          fetch(`../../controllers/usuario.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);
              cuerpo.innerHTML ='';

              datos.forEach(element =>{
                let nuevacard = ``;
                // Enviar los valores obtenidos en celdas <td></td>
                nuevacard = `
                <div class="card mb-3" style="max-width: 540px;">
                  <div class="row g-0">
                      <div class="col-md-4">
                      <img src="..." class="img-fluid rounded-start" alt="...">
                      </div>
                      <div class="col-md-8">
                      <div class="card-body">
                          <h5 class="card-title">${element.nombres} ${element.apellidos}</h5>
                          <p class="card-text">correo: ${element.email}</p>
                          <p class="card-text">cargo: ${element.rol}</p>
                          <div class="container">
                          <button type="button" data-userid="${element.idusuario}" id="editar"  class="btn btn-sm btn-warning">Editar</button>
                          <button type="button" data-userid="${element.idusuario}" id="eliminar" class="btn btn-sm btn-danger">Eliminar</button>
                          </div>
                      </div>
                      </div>
                  </div>
              </div>  
                `;
                cuerpo.innerHTML += nuevacard;             
              });
            })
            .catch(e =>  {
              console.error(e);
            });               
        }


        function registrar_usuarios(){
          const parametros = new FormData();
          parametros.append("operacion"     ,"registrar_usuario");
          parametros.append("nombres"       ,$("#nombres").value);
          parametros.append("apellidos"     ,$("#apellidos").value);
          parametros.append("rol"           ,$("#rol").value);
          parametros.append("claveacceso"   ,$("#contraseña").value);
          parametros.append("email"         ,$("#email").value);
          parametros.append("avatar"        ,$("#avatar").value);

          fetch(`../../controllers/usuario.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);
            if (datos.idusuario > 0){
            alert(`Usuario registrado con ID: ${datos.idusuario}`)
            $("#form-usuario").reset();  

            }

            })
            .catch(e =>  {
              console.error(e);
            });               
        }

        // function eliminar_usuarios(){
        //   const parametros = new FormData();
        //   parametros.append("operacion"     ,"registrar_usuario");
        //   parametros.append("idusaurio"       ,$("#nombres").value);

        //   fetch(`../../controllers/usuario.controller.php`,{
        //     method: "POST",
        //     body : parametros
        //   })
        //     .then(respuesta => respuesta.json())
        //     .then(datos => {
        //       console.log(datos);
        //     if (datos.idusuario > 0){
        //     alert(`Usuario registrado con ID: ${datos.idusuario}`)
        //     $("#form-usuario").reset();  

        //     }

        //     })
        //     .catch(e =>  {
        //       console.error(e);
        //     });               
        // }
        
        
        // $('#eliminar').addEventListener('click', function(){
        //   usuario   = $('#eliminar').getAttribute('data-userid');
        //   console.log("usuario")
        // });
        listar_usuarios();

        $("#eliminar").addEventListener('click',function(){
          console.log("hola");
          usuario   = $('#eliminar').getAttribute('data-userid');
          console.log(usuario)
        });

        $('#registrar').addEventListener('click', function(){
          usuario   = $('#eliminar').getAttribute('data-userid');
          console.log(usuario)
          // registrar_usuarios();

        });


    });

  </script>
</body>


</html>