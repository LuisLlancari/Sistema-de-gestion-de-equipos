<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">
    <div class = "container mt-3">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">

        <div class="mb-3">
         <h1>Lista de trabajdores</h1>
         <button type="button" class="btn btn-primary" id="registro">Agregar usuario</button>
        </div>
      </div>
      <div class="col-md-4"></div>
    </div>
  <div>

  <div class="container mx-3">
    <div class="row row-cols-1 row-cols-md-3 g-4" id="contenerdor-cards">
        
    <div class="card mb-3" style="max-width: 540px;">
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
    </div>  



    
    </div>
  </div>
  <!-- INICIO DEL MODAL TREGISTRAR USUARIO -->

    <div class="modal fade" id="modal-registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="titulo-modal">Registrar usuario</h1>
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
                  <option value="ADMIN">Administrador</option>
                  <option value="ASIST">Asistente</option>
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
          <button type="button" class="btn btn-primary" id="agregar" >Agregar Usuario</button>
        </div>
      </div>
    </div>
  </div>

    </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
    
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
  
  <script src="../../js/sidebar.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded",() => {
        const cuerpo = document.querySelector("#contenerdor-cards");
        var modalregistro = new bootstrap.Modal($('#modal-registrar'));
        function $(id){return document.querySelector(id)};
        
        let varBandera = true;
  

        //FUNCION QUE LISTA A LOS USUARIOS EN CARDS
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
                const rutaImagen = (element.avatar == null)  ? "noimagen.png": element.avatar;
                let nuevacard = ``;
                // Enviar los valores obtenidos en celdas <td></td>
                nuevacard = `
                <div class="card mx-3" style="max-width: 540px;" id="cuepo-card">
                  <div class="row g-0 justify-content-center">
                      <div class="col-md-4">
                      <img src="../../images/${rutaImagen}" class="img-fluid" alt="...">
                      </div>
                      <div class="col-md-8">
                      <div class="card-body">
                          <h5 class="card-title">${element.nombres} ${element.apellidos}</h5>
                          <p class="card-text">correo: ${element.email}</p>
                          <p class="card-text">cargo: ${element.rol}</p>
                          <div class="container">
                          <button type="button" data-id="${element.idusuario}"  class="btn btn-sm btn-warning editar">Editar</button>
                          <button type="button" data-id="${element.idusuario}"  class="eliminar btn btn-sm btn-danger ">Eliminar</button>
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

        //FUNCION QUE REGISTRA UN USUARIO
        function registrar_usuarios(){
          var  usuario  = $('#agregar').getAttribute('userid');

          const parametros = new FormData();
          parametros.append("nombres"       ,$("#nombres").value);
          parametros.append("apellidos"     ,$("#apellidos").value);
          parametros.append("rol"           ,$("#rol").value);
          parametros.append("email"         ,$("#email").value);
          parametros.append("avatar"        ,$("#avatar").files[0]);

          if(varBandera){

            parametros.append("operacion"     ,"registrar_usuario");
            parametros.append("claveacceso"   ,$("#contraseña").value);
          }else{
            parametros.append("operacion"     ,"modificar_usuario");
            parametros.append("idusuario"     ,usuario);
          }
          
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
            // listar_usuarios()
            }
            })
            .catch(e =>  {
              console.error(e);
            });               
        }

        //FUNCION QUE ELEMINA UN USUARIO POR ID
        function eliminar_usuarios(idusuario){
          const parametros = new FormData();
          parametros.append("operacion"     ,"eliminar_usuario");
          parametros.append("idusuario"     ,idusuario);

          fetch(`../../controllers/usuario.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {

            }
            )
            .catch(e =>  {
              console.error(e);
            });               
        }

        //FUNCION QUE TRAE EL LOS DATOS DE LOS USUARIOS POR ID
        function recupear_usuarios_id(idusuario){

          $("#form-usuario").reset();  
          $("#titulo-modal").innerText = "Editar Usuario";
          $("#contraseña").setAttribute('disabled','true');
          const parametros = new FormData();
          parametros.append("operacion"     ,"listar_usuario_por_id");
          parametros.append("idusuario"     ,idusuario);

          fetch(`../../controllers/usuario.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos)
              modalregistro.show();
              // modalregistro.reset();
              
              $("#nombres").value     = datos.nombres;
              $("#apellidos").value   = datos.apellidos;
              $("#rol").value         = datos.rol;
              $("#email").value       = datos.email;
              $('#agregar').setAttribute('userid',datos.idusuario)
              // $("#avatar").value

              
            })
            .catch(e =>  {
              console.error(e);
            });               
        }
        
        
        
        // FUNCION QUE LISTA A LOS USUARIOS
        // listar_usuarios();


        //ESTO LEE EL EVENTO CLICK DEL BOTON EDITAR O ELIMINAR
        $("#contenerdor-cards").addEventListener('click',(event)=>{
           var usuarioid= event.target.dataset.id;
            
          if(event.target.classList.contains("editar")){

            varBandera = false;
            recupear_usuarios_id(usuarioid);

          }else if(event.target.classList.contains("eliminar")){         
            eliminar_usuarios(usuarioid);
            // listar_usuarios();
          }
        });


        //ESTE BOTON ABRE EL MODAL PARA "REGISTRAR"
        $('#registro').addEventListener('click', function(){
          varBandera = true;
          $("#contraseña").removeAttribute('disabled');
          $("#form-usuario").reset();  
          modalregistro.show();
        });


        //ESTE BOTON ENVIA LOS DATOS DEL FORMULARIO, SEA LISTAR O REGISTRAR
        $('#agregar').addEventListener('click', function(){
          registrar_usuarios();
        });
        

    });

  </script>
</body>


</html>