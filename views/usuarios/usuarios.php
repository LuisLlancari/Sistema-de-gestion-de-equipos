<?php

require_once "../sidebar/sidebar.php";
?>  

<head>
<title>Usuarios</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

  <div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="m-4">
        <h1 class="fw-bolder d-inline-block"><i class="bi bi-person-lines-fill"></i> LISTA DE ENCARGADOS</h1>
        <div class="btn-container float-end">
          <!-- AÑADIR USUARIO -->
          <button type="button" class="btn btn-primary rounded-circle" id="registro">
          <i class="bi bi-person-fill-add" style="font-size: 1.5em;"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>




  <div class="container">
    <div class="row row-cols-3 g-4" id="contenerdor-cards">
        
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
        <div class="modal-header"  style="background-color: #666666;">
          <h1 class="modal-title fs-5 text-light" id="titulo-modal">Registrar usuario</h1>
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
                  <option value="ADMINISTRADOR">Administrador</option>
                  <option value="ASISTENTE">Asistente</option>
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

                <div class="md-3">
                  <label for="fotografia" class="form-label">Fotografia</label>
                  <input type="file" class="form-control" id="avatar" accept=".jpg">
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="agregar" class="btn btn-outline-primary flex-fill"><i class="bi bi-check-square-fill"></i>    Guardar</button>
          <button type="button" id="cerrar" data-bs-dismiss="modal" class="btn btn-outline-danger flex-fill" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>    Cerrar</button>
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
  <script src="../../js/sweeAlert.js"></script>


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
                <div class="card mx-3" style="width: 470px;" id="cuepo-card">
                  <div class="row g-0 align-items-center">
                    <div class="col-md-4">
                      <img src="../../images/${rutaImagen}" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title"><strong>${element.nombres} ${element.apellidos}</strong></h5>
                        <hr>
                        <p class="card-text">Correo: ${element.email}</p>
                        <p class="card-text">Cargo: ${element.rol}</p>
                        <div class="container">
                          <button type="button" data-id="${element.idusuario}" class="btn btn-sm btn-warning editar">Editar</button>
                          <button type="button" data-id="${element.idusuario}" class="eliminar btn btn-sm btn-danger ">Eliminar</button>
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
            // alert(`Usuario ID: ${datos.idusuario}`)
            toast("Operación realizada con éxito")
            $("#form-usuario").reset();  
            modalregistro.hide();
            listar_usuarios();
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
              if(datos.idusuario > 0){
                console.log(datos);
                $("#form-usuario").reset();  
                modalregistro.hide();
                listar_usuarios();            
                toast("Operación realizada con éxito");

              }

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
        listar_usuarios();


        //ESTO LEE EL EVENTO CLICK DEL BOTON EDITAR O ELIMINAR
        $("#contenerdor-cards").addEventListener('click',(event)=>{
           var usuarioid= event.target.dataset.id;
            
          if(event.target.classList.contains("editar")){

            varBandera = false;
            recupear_usuarios_id(usuarioid);

          }else if(event.target.classList.contains("eliminar")){       

            mostrarPregunta("Por favor confirme","¿Desea eliminar este registro?",() =>{
                  eliminar_usuarios(usuarioid);
                });


            // mostrarPregunta("Por favor confirme","¿Desea eliminar este registro?",eliminar_usuarios(usuarioid))  
            // eliminar_usuarios(usuarioid);
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


          if(varBandera){
            mostrarPregunta("Por favor confirme","¿Desea Agregar este registro?",() =>{
            registrar_usuarios()});

          }else{
            mostrarPregunta("Por favor confirme","¿Desea Editar este registro?",() =>{
            registrar_usuarios();
          });
          }


          
          
        });
        

    });

  </script>
</body>


</html>