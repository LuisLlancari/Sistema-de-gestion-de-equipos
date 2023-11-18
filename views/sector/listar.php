<?php
require_once "../../views/sidebar/sidebar.php";
?>  

<!doctype html>
<html lang="en">

<head>
<title>Sectores</title>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="btn-sidebar toggled" id="menu-toggle">
        <span class="fas fa-bars"></span>
      </div>
      <div class="m-4">
        <h1 class="fw-bolder d-inline-block"><i class="bi bi-shop-window"></i> SECTORES</h1>
        <div class="btn-container float-end">
          <button class="btn btn-primary rounded-circle">
            <i class="bi bi-plus-circle-fill" style="font-size: 1.5em;"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="lista-sectores">

</div>

<!-- CARD OBLIGATORIO: GENERAL ALMACÉN
<div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col">
    <a href="../../views/sector/detalle_sector.php" id="card-almacen" class="card text-center border-yellow" style="width: 400px; cursor: pointer; text-decoration: none; color: black;">
      <img src="../../test/almacen.jpg" class="card-img-top" alt="..." style="width: 400px; height: 250px;">
      <div class="card-body">
        <h4 class="card-title">ALMACÉN</h4>
        <p class="card-text">Cantidad: 00</p>
      </div>
    </a>
  </div>
</div>  -->


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
    function $(id){
      return document.querySelector(id);
    }

    function mostrarSectores() {
      const parametros = new FormData();
      parametros.append("operacion", "obtenerNC");

      fetch(`../../controllers/sector.controller.php`, {
        method: "POST",
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
          console.log("Datos recibidos:", datos);

          if (datos.length === 0) {
            $("#lista-sectores").innerHTML = `<p>Recarge la página </p><i class="bi bi-arrow-counterclockwise"></i>`;
          } else {
            $("#lista-sectores").innerHTML = ``;
            datos.forEach(element => {
              // Renderizado
              const nuevoItem =`
                <div class="col-md-4 mb-4">
                  <a href="../../views/sector/detalle_sector.php?sector=${element.idsector}" data-sector="${element.idsector}" class="card text-center border-yellow" style="width: 100%; cursor: pointer; text-decoration: none; color: black;">
                    <img src="../../test/sector.jpg" class="card-img-top" alt="${element.Nombre_Sector}" style="width: 100%; height: 250px;">
                    <div class="card-body">
                      <h4 class="card-title">${element.Nombre_Sector}</h4>
                      <p class="card-text">Cantidad: ${element.Cantidad_Guardados}</p>
                    </div>
                  </a>
                </div>
              `;
              $("#lista-sectores").innerHTML += nuevoItem;
            });
          }
        })
        .catch(e => {
          console.error(e);
        });
    }

    mostrarSectores();

  </script>

</body>

</html>