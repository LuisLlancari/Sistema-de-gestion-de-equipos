<?php
require_once "../sidebar/sidebar.php";
?>  

<!--  -->
<!doctype html>
<html lang="en">

<head>
<title>Detalles del Sector</title>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="m-4">
        <h1 class="fw-bolder d-inline-block"><i class="bi bi-card-checklist"> </i><span id="sector"></span></h1>
      </div>
    </div>
  </div>

  <div>
    <h4 id="mensajeSector">Equipos que se encuentran en este sector:</h4>
  </div>
  <hr>

  <table class="table table-sm table-striped" id="tabla-detalle-sector">
    <colgroup>
        <col width="3%"> <!--Codigo -->
        <col width="11%"> <!-- Equipo -->
        <col width="21%"> <!-- Marca/Modelo  -->
        <col width="15%"> <!-- Número de Serie -->
        <col width="10%"> <!-- Ingreso -->
        <col width="10%"> <!-- Salida -->
        <col width="23%"> <!-- Usuario de Registro -->
        <col width="5%"> <!-- Comandos -->
      </colgroup>
      <thead>
          <tr>
            <th>#</th>
            <th>Equipo</th>
            <th>Marca/Modelo</th>
            <th>Número de Serie</th>
            <th>Ingreso</th>
            <th>Salida </th>
            <th>Registrado por:</th>
            <th></th>
          </tr>
      </thead>
      <tbody>
          <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
      </tbody>
  </table>

</div>


   <!--MODAL: CAMBIO DE SECTOR-->
   <div class="modal fade" id="modal-cambio" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4285f4;">
        <h5 class="modal-title text-light">Cambiar de Sector</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="uno" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Contenido del modal -->
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card text-center border-yellow">
                  <img src="../../images/logo/sector.jpg" class="card-img-top" alt="..." style="width: 100%; height: 250px;">
                  <form action="" id="formulario1">
                      <div class="card-body">
                      <select name="" id="sectores" class="form-select" required>
                        <option value="">Seleccion:</option>
                      </select>
                      </div>
                  </form>
              </div>
          </div>
      </div>
        <hr>
        <button type="button" class="btn btn-outline-primary mx-auto" id="boton_guardar" style="width: 200px;"><i class="bi bi-check-square-fill"></i> Enviar</button>
      </div>
    </div>
  </div>
</div>
</main>





  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <script src="../../js/sidebar.js"></script>
  <script src="../../js/sweeAlert.js"></script>

  <script>

    document.addEventListener("DOMContentLoaded", () => {

      function $(id){return document.querySelector(id);}
      var modalcambio = new bootstrap.Modal($('#modal-cambio'));


    
      const tabla = document.querySelector("#tabla-detalle-sector tbody");
      const nombreSectorElemento = document.getElementById("sector");
      const sectorId = new URLSearchParams(window.location.search).get('sector');
      const nombreSector = new URLSearchParams(window.location.search).get('nombre');


      nombreSectorElemento.innerText = nombreSector;

      function listarDetalles(){
        const parametros = new FormData();
        parametros.append("operacion", "listar_detalles_sector");
        parametros.append("idsector", sectorId);

        fetch(`../../controllers/sector.controller.php`, {
          method: 'POST', 
          body: parametros
        })
          .then(respuesta => respuesta.json())
          .then(datosRecibidos => {
            if (datosRecibidos.length > 0) {

                let numFila = 1;
                tabla.innerHTML = '';
                datosRecibidos.forEach(registro => {
                    let nuevafila = `
                    <tr>
                        <td>${numFila}</td>
                        <td>${registro.categoria}</td>
                        <td>${registro.marca} - ${registro.modelo_equipo}</td>
                        <td>${registro.numero_serie}</td>
                        <td>${registro.fecha_inicio}</td>
                        <td>${registro.fecha_fin !== null ? registro.fecha_fin : 'No definido'}</td>
                        <td>${registro.apellidos}, ${registro.nombres}</td>
                        <td style='text-align: center; vertical-align: middle;'>
                            <button class='btn btn-primary btn-sm rounded-circle' id='${registro.idmantenimiento_sector}' type='button'><i class="bi bi-arrow-left-right cambio" id='${registro.idmantenimiento_sector}'></i></button>
                        </td>
                    </tr>
                    `;

                    tabla.innerHTML += nuevafila;
                    numFila++;
                });
            } else {
                // Si no hay datos, muestra un mensaje
                mensajeSector.innerHTML = "<i class='bi bi-info-circle'></i> No existen equipos asignados a este sector";
            }
          })
          .catch(e => {
            console.error(e)
          })
      }

      function getSector(){
        const parametros = new FormData();
        parametros.append("operacion", "obtenerNC");

        fetch(`../../controllers/sector.controller.php`, {
            method: "POST",
            body: parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              datos.forEach(element => {
                const tagOption = document.createElement("option")
                tagOption.value = element.idsector
                tagOption.innerText = element.Nombre_Sector
                $("#sectores").appendChild(tagOption);

              });
            })
            .catch(e => {
              console.error(e);
            });
      }

      function moverEquipo(){

        iddetallesector = $('#boton_guardar').getAttribute('data-id');
        const parametros = new FormData();
        parametros.append("operacion", "mover_equipo");
        parametros.append("iddetallesector", iddetallesector);
        parametros.append("idsector", $('#sectores').value);

        fetch(`../../controllers/sector.controller.php`, {
            method: "POST",
            body: parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);
              if(datos.length > 0){
                console.log("folda")
                $("#formulario1").reset();
                  modalcambio.hide();
                  listarDetalles();

              }else{
                console.log("ha ocurrido un error")
        
              }
              listarDetalles();


             
            })
            .catch(e => {
              console.error(e);
            });
      }
      




      listarDetalles();
      getSector();

      $("#tabla-detalle-sector tbody").addEventListener('click',(event)=>{
           var iddetalle_sector= event.target.id;

         

          if(event.target.classList.contains("cambio")){

            $('#boton_guardar').setAttribute('data-id',iddetalle_sector)  
            modalcambio.show();
            
            


          }else if(event.target.classList.contains("algo")){         
          ''
          }
        });


      $('#boton_guardar').addEventListener('click',()=>{
        moverEquipo();
      });

    });
</script>

</body>

</html>