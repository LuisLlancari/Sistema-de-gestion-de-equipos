<?php
require_once "../sidebar/sidebar.php";
?>  
<!doctype html>
<html lang="en">

<head>
  
</head>

<body>

  <div class="mt-4">
    <table class="table table-striped" id="tabla-sectores">
      <colgroup>
      <col width="5%"> <!-- Codigo -->
      <col width="15%"> <!-- Sector -->
      <col width="15%"> <!-- Equipo -->
      <col width="15%"> <!-- Número de Serie -->
      <col width="15%"> <!-- Usuario de Registro -->
      <col width="10%"> <!-- Ingreso -->
      <col width="10%"> <!-- Salida -->
      <col width="15%"> <!-- Comandos -->
    </colgroup>
    <thead>
      <tr>
        <th>#</th>
        <th>Sector Asignado</th>
        <th>Equipo</th>
        <th>Número de Serie</th>
        <th>Usuario</th>
        <th>Ingreso</th>
        <th>Salida </th>
        <th>Opraciones</th>
      </tr>
    </thead>
    <tbody>
         <!-- Datos Asincronos -->
    </tbody>

    </table>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script src="../../js/sidebar.js"></script>
  <script src="../../js/sweeAlert.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const tabla = document.querySelector("#tabla-sectores tbody");

    function listarSectores(){
      const parametros = new FormData();
      parametros.append("operacion", "listar")

      fetch(`../../controllerS/sector.controller.php`, {
        method: 'POST',
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datosRecibidos => {
          let numFila = 1;
          tabla.innetHTML = '';

          datosRecibidos.forEach(registro => {
            let numfila = ``;
            nuevafila = `
              <tr>
                <td>${numFila}</td>
                <td>${registro.sector}</td>
                <td>${registro.categoria}</td>
                <td>${registro.numero_serie}</td>
                <td>${registro.nombres}</td>
                <td>${registro.fecha_inicio}</td>
                <td>${registro.fecha_fin}</td>
                <td>
                <button class='btn btn-danger btn-sm eliminar' type='button'>Operaciones</button>
                </td>
              </tr>            
            `;
              tabla.innerHTML += nuevafila;
              numFila++;
          })
        })
          .catch(e => {
            console.error(e)
        })
    }

    tabla.addEventListener("click", (event) => {
        
        if (event.target.classList.contains("eliminar")){
          const idproducto = event.target.dataset.idproducto;
          const parametros = new FormData();
          parametros.append("operacion", "eliminar");
          parametros.append("idproducto", idproducto);
          console.log(idproducto);

          if (confirm("¿Está seguro de eliminar?")){
            fetch(`../../controllers/producto.controller.php`, {
              method: "POST",
              body: parametros
            })
              .then(respuesta => respuesta.text())
              .then(datos => {
                console.log(datos);
                listarProductos();
              })
              .catch(e => {
                console.error(e);
              });
          }
        }

        if(event.target.classList.contains("editar")){
          console.log("Proceso de edición")
        }
      });

      listarSectores();

    });

    

  </script>

</body>

</html>