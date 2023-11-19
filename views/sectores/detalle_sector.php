<?php
require_once "../../views/sidebar/sidebar.php";
?>  

<!doctype html>
<html lang="en">

<head>
<title>Detalles del Sector</title>
</head>
<body>

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




  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <script src="../../js/sweeAlert.js"></script>

  <script>

    function $(id){
      return document.querySelector(id);
    }

    document.addEventListener("DOMContentLoaded", () => {

      const tabla = document.querySelector("#tabla-detalle-sector tbody");
      const nombreSectorElemento = document.getElementById("sector");
      const sectorId = new URLSearchParams(window.location.search).get('sector');
      const nombreSector = new URLSearchParams(window.location.search).get('nombre');

      console.log(nombreSector);
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
                            <button class='btn btn-primary btn-sm rounded-circle' type='button'><i class="bi bi-arrow-left-right"></i></button>
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

      listarDetalles();

    });
</script>

</body>

</html>