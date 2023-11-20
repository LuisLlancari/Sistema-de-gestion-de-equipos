<?php

require_once "../sidebar/sidebar.php";


?>




<div class="text-center mt-3">
  <h1>Panel Mantenimiento</h1>
</div>

  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="btn-sidebar toggled" id="menu-toggle">
        </div>
        <div class="m-4">
          <h1 class="fw-bolder d-inline-block"><i class="bi bi-card-checklist"> </i><span id="sector"></span></h1>
        </div>
      </div>
    </div>

    

    <div class="container">
      <div class="container mx-3">
      </div>
          <!-- FILTROS -->
          
          <div class="row mb-3">
            <div class="col-md-2">
              <h4>Filtros:</h4>
            </div>
            <div class="col-md-2">
              <select name="marcaS" class="form-select"id="marcaS">
              <option value="0">Seleccion:</option>

              </select>
            </div>
            
            <div class="col-md-2">
              <select name="categoriasS" class="form-select" id="categoriasS">
              <option value="0">Seleccion:</option>

              </select>
            </div>

         

            <div class="col-md-4">
              <div class="input-group"></div>
            </div>
          </div>
  
      </div>
      <table class="table table-sm table-striped" id="tabla-mantenimiento">
      <colgroup>
      <col width="4%"> <!--Codigo -->
          <col width="11%"> <!-- usuario -->
          <col width="24%"> <!-- categoria -->
          <col width="15%"> <!-- Número de Serie -->
          <col width="15%"> <!-- F_mantenimiento -->
          <col width="15%"> <!-- T-mantenimiento -->
          <col width="15%"> <!-- T-mantenimiento -->
          <col width="5%"> <!-- Edit -->
        </colgroup>
        <thead class="text-center">
            <tr>
              <th>#</th>
              <th>Usuaio</th>
              <th>Equipo</th>
              <th>Número de Serie</th>
              <th>F_mantenimiento</th>
              <th>T-mantenimiento</th>
              <th>Descripcion</th>
              <th>Edit</th>
            </tr>
          </thead>
        <tbody  class="text-center">
            <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
          </tbody>
    </table>
  </div>
  
   <!-- Modal Body -->
  <div class="modal fade" id="modal-comentario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-light">
          <h5 class="modal-title" id="modalTitleId">Descripción del mantenimiento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="comentario" class="form-label text-center">Comentario</label>
            <textarea class="form-control" id="comentario" rows="3" required ></textarea>
            <div class="invalid-feedback"> Ingresar comentario. </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-success" data-bs-dismiss="modal" id ="enviar">Enviar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

<script src="../../js/sidebar.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
     document.addEventListener("DOMContentLoaded",() => {
        function $(id){return document.querySelector(id)};
        var modalcomentario = new bootstrap.Modal($('#modal-comentario'));
        const tabla = $("#tabla-mantenimiento tbody");


        function obtenerMarcas(){
          const parametros = new FormData();
          parametros.append("operacion","listar");

          fetch(`../../controllers/marca.controller.php`,{
            method: "POST",
            body: parametros
          })
            .then(result => result.json())
            .then(data => {

              if(data.length > 0){

                data.forEach(element => {
                  
                  const tagOption = document.createElement("option");

                  tagOption.innerText = element.marca;
                  tagOption.value     = element.idmarca;
                
                $("#marcaS").appendChild(tagOption); 
                });
              }
            })
            .catch(e => {
              console.error(e);
            });
        }


        function obtenerCategorias(){
          const parametros = new FormData();
          parametros.append("operacion","listar");

          fetch(`../../controllers/categoria.controller.php`,{
            method: "POST",
            body: parametros
          })
            .then(result => result.json())
            .then(data => {

              if(data.length > 0){

                data.forEach(element => {
                  
                  const tagOption = document.createElement("option");

                  tagOption.innerText = element.categoria;
                  tagOption.value     = element.idcategoria;
                
                $("#categoriasS").appendChild(tagOption); 
                });
              }
          });  
        }

        function listar_mantenimiento(idusuario){
          const parametros = new FormData();

          parametros.append("operacion"     ,"listar_mantenimiento");
          parametros.append("categoria"     ,$("#categoriasS").value);
          parametros.append("marca"     ,$("#marcaS").value);


          fetch(`../../controllers/mantenimiento.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);

              tabla.innerHTML = '';
               if(datos.length >0){

                  let numFila = 1;
                  tabla.innerHTML = '';
                  datos.forEach(registro => {
                    let nuevafila = `
                    <tr>
                        <td>${numFila}</td>
                        <td>${registro.nombres}</td>
                        <td>${registro.categoria} ${registro.equipo}</td>
                        <td>${registro.numero_serie}</td>
                        <td>${registro.fecha_del_mantenimiento}</td>
                        <td>${registro.tipo_mantenimiento}</td>
                        <td>
                          <a href='#' class='comentarios' descripcion="${registro.idmantenimiento}" name="${registro.descripcion}">Ver</a>
                        </td>
                        <td style='text-align: center; vertical-align: middle;'>
                            <button class='btn btn-warning editar' id="${registro.idmantenimiento}" type='button'>Edit</button>
                        </td>
                    </tr>
                    `;

                    tabla.innerHTML += nuevafila;
                    numFila++;
                   });
               }else{
          
               }
            }
            )
            .catch(e =>  {
              console.error(e);
            });               
        }
        
        function editarMantenimiento(){

          var  mantenimientoid  = $('#enviar').getAttribute('mantenimiento-id');
          console.log(mantenimientoid)
          const parametros = new FormData();
          parametros.append("operacion"     ,"modificar_mantenimiento");
          parametros.append("idmantenimiento"     ,mantenimientoid);
          parametros.append("descripcion"     ,$('#comentario').value);

          fetch(`../../controllers/mantenimiento.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              
              modalcomentario.hide();
              listar_mantenimiento();
            })
            .catch(e =>  {
              console.error(e);
            });               
        }

        obtenerCategorias();
        obtenerMarcas();
        listar_mantenimiento();

        
        $("#tabla-mantenimiento tbody").addEventListener('click',(event)=>{
          // var cronogramaid= event.target.dataset.id;
          var mantnimientoDescripcion= event.target.name;
          var idmantenimiento= event.target.id;
          console.log(mantnimientoDescripcion);
          console.log(idmantenimiento);

          $("#comentario").value = mantnimientoDescripcion;
          $("#enviar").setAttribute('mantenimiento-id',idmantenimiento);
          


           if(event.target.classList.contains("comentarios")){

            $("#comentario").setAttribute('disabled','true');
            $("#comentario").setAttribute('readOnly','true');
            $('#enviar').style.display = "none";
            
            modalcomentario.show();
            }
            
            if(event.target.classList.contains("editar")){
              $('#enviar').style.display = "block";
              $("#comentario").removeAttribute('disabled');
              $("#comentario").removeAttribute('readOnly');
              modalcomentario.show();

            }

        });
        
        $("#categoriasS").addEventListener("change",() =>{
          listar_mantenimiento();
        })
      
        $("#marcaS").addEventListener("change",() =>{
          listar_mantenimiento();      
        })

        $("#enviar").addEventListener("click",() =>{
          editarMantenimiento();      
        })


    });
  </script>
</body>

</html>