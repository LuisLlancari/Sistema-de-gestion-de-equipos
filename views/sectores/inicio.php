<?php
require_once "../../views/sidebar/sidebar.php";

global $apellidos, $nombres, $idusuario;
$apellidos = $_SESSION["apellidos"];
$nombres = $_SESSION["nombres"];

?>  

<!-- TODO EL HEAD Y PARTE DEL BOY NO DEBERIA ESTAR YA QUE EXIST EN EL SIDEBAR -->
<!doctype html>
<html lang="en">

<head>
<title>Sectores</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="m-4">
        <h1 class="fw-bolder d-inline-block"><i class="bi bi-shop-window"></i> SECTORES</h1>
        <div class="btn-container float-end">
          <!-- AÑADIR SECTOR -->
          <button class="btn btn-primary rounded-circle" type="submit" id="guardar" data-bs-toggle="modal" data-bs-target="#miModal" title="Agregar Sector" style="margin-right: 5px;">
            <i class="bi bi-plus-circle-fill" style="font-size: 1.5em;"></i>
          </button>
          <!-- AÑADIR EQUIPO A SECTOR -->
          <button class="btn btn-warning rounded-circle" id="equipoAsector" title="Asignar equipos a un Sector" style="margin-right: 5px;">
            <i class="bi bi-file-earmark-plus" style="font-size: 1.5em;"></i>
          </button>
          <!-- ELIMINAR -->
          <button class="btn btn-danger rounded-circle" id="boton_eliminar" type="button" data-bs-toggle="modal" title="Eliminar Sector">
            <i class="bi bi-trash3-fill" style="font-size: 1.5em;"></i>
          </button>
        </div>
        <hr>
      </div>
    </div>
  </div>
</div>

<div class="row" id="lista-sectores">

</div>



    <!--MODAL: AÑADIR SECTOR-->
<div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4285f4;">
        <h5 class="modal-title text-light">Agregar nuevo sector</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="uno" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Contenido del modal -->
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card text-center border-yellow">
                  <img src="../../test/sector.jpg" class="card-img-top" alt="..." style="width: 100%; height: 250px;">
                  <form action="" id="formulario1">
                      <div class="card-body">
                        <input type="text" class="form-control" id="sector_nuevo" required>
                      </div>
                  </form>
              </div>
          </div>
      </div>
        <hr>
        <button type="button" class="btn btn-outline-primary mx-auto" id="boton_guardar" style="width: 200px;"><i class="bi bi-check-square-fill"></i> Agregar</button>
      </div>
    </div>
  </div>
</div>
</main>


<!-- MODAL: AÑADIR EQUIPO A SECTOR -->
<div class="modal fade" id="ModalEquipoAsector" tabindex="-1" aria-labelledby="miModalEquipoAsectorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #ffdd87;">
        <h5 class="modal-title">Añadir equipo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Contenido del modal -->


        <div class="modal-body">
          <form action="" autocomplete="off" id="form-equiposAsector">


          <div class="row">
            <div class="col-md-6 mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select id="categoria" name="categoria" class="form-select" required>
                  <option value="">Seleccione:</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <select id="marca" name="marca" class="form-select" required>
                  <option value="">Seleccione:</option>
                </select>
              </div>
            </div>

            <div class ="row">
              <div class="col-md-6">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="modelo" class="form-control text-end" id="modelo" name="modelo" required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="num_serie" class="form-label">Número de Serie</label>
                <input type="text" class="form-control text-end" id="num_serie" name="num_serie" required>
              </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="sector" class="form-label">Sector</label>
                  <select id="sector" name="sector" class="form-select" required>
                    <option value="">Almacén</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="usuario" class="form-label">Usuario</label>
                  <input class="form-control" type="text" aria-label="Disabled input example" id="idusuario" value="<?php echo $nombres . ' ' . $apellidos; ?>" disabled>
                </div>
            </div>

            <div class="mb-3">
                  <label for="imagen" class="form-label">Imagen</label>
                  <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg">
              </div>

              <div class="mb-3">
                  <label for="descripcion" class="form-label">Descripcion</label>
                  <textarea class="form-control" id="descripcion" rows="3"></textarea>
              </div>

          </form>
        </div>
        
      </div>
      <div class="row">
      <div class="modal-footer d-flex justify-content-between">
          <button type="submit" id="guardarEquipo_Sector" class="btn btn-outline-primary flex-fill"><i class="bi bi-check-square-fill"></i>    Guardar</button>
          <button type="button" id="eliminarEquipo_Sector" class="btn btn-outline-danger flex-fill" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i>    Cancelar</button>
        </div>
      </div>


    </div>
  </div>
</div>



<!--MODAL: ELIMINAR SECTOR-->
<div class="modal fade" id="modalEliminarSector" tabindex="-1" aria-labelledby="modalDetallesSectorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-light">Eliminar Sector</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <!-- Contenido del modal -->
    <div class="modal-body text-center">
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading"><strong>¡CUIDADO!</strong></h4>
          <p>Al borrar un sector, eliminará también los equipos asociados.</p>
        </div>
    <table class="table table-sm table-striped table-hover" id="tabla_eliminar">
      <colgroup>
        <col width="25%"> <!-- # -->
        <col width="25%"> <!-- sector  -->
        <col width="25%"> <!-- cantidad -->   
      </colgroup>
    <thead>
      <tr>
        <th>#</th>
        <th>Sector</th>
        <th>Cantidad de Registros</th>
      </tr>
    </thead>
      <tbody id="detalleSectorBody">
      <!-- Datos Asincronos -->
      </tbody>
    </table>
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
    
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
  
  <script src="../../js/sidebar.js"></script>


  <script>

  document.addEventListener("DOMContentLoaded", () => {

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

          if (datos.length == 0) {
            $("#lista-sectores").innerHTML = `<h4>No tiene Sectores registrados <i class="bi bi-building-slash"></i></h4>`;
          } else {
            $("#lista-sectores").innerHTML = ``;
            datos.forEach(element => {
              // Renderizado
              const nuevoItem =` 
                <div class="col-md-4 mb-4">
                  <a href="../../views/sectores/detalle_sector.php?sector=${element.idsector}&nombre=${element.Nombre_Sector}" data-sector="${element.idsector}" class="card text-center border-yellow" style="width: 100%; cursor: pointer; text-decoration: none; color: black;">
                    <img src="../../test/sector.jpg" class="card-img-top" alt="${element.Nombre_Sector}" style="width: 100%; height: 200px;">
                    <div class="card-body">
                      <h3 class="card-title">${element.Nombre_Sector}</h3>
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


    function sectorRegister() {
    const nuevoSector = document.getElementById("sector_nuevo").value.trim();
    console.log("Sector añadido:", nuevoSector); 

    if (nuevoSector !== "") {
        const parametros = new FormData();
        parametros.append("operacion", "registrar");
        parametros.append("sector", nuevoSector);

        fetch(`../../controllers/sector.controller.php`, {
            method: "POST",
            body: parametros
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            console.log(datos);
            if (datos.idsector > 0) {
                alert(`Sector registrado con ID: ${datos.idsector}`);
                document.getElementById("formulario1").reset();
              } 
              })
              .catch(e =>  {
                  console.error(e);
              });               
          }
    }

    document.getElementById("boton_guardar").addEventListener("click", () => {
        if (confirm("¿Está seguro de guardar?")) {
            sectorRegister();
        }
    });
    mostrarSectores();


    const tabla = document.querySelector("#tabla_eliminar tbody");
    function GetSector() {
      const parametros = new FormData();
      parametros.append("operacion", "obtenerNC");

      fetch(`../../controllers/sector.controller.php`, {
        method: 'POST',
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datosRecibidos => {
          let numFila = 1;
          tabla.innerHTML = '';

          datosRecibidos.forEach(registro => {
            let nuevafila = `
              <tr>
                <td>${numFila}</td>
                <td>${registro.Nombre_Sector}</td>
                <td>${registro.Cantidad_Guardados}</td>
                <td>
                  <button type="button" id="drop" data-idsector="${registro.idsector}" class="btn btn-outline-danger btn-sm eliminar"><i class="bi bi-trash3"></i></button>
                </td>
              </tr>`;
            tabla.innerHTML += nuevafila;
            numFila++;
          });

          document.querySelectorAll('.eliminar').forEach(btnEliminar => {
            btnEliminar.addEventListener('click', function () {
              const idSector = this.dataset.idsector;
              eliminarSector(idSector);
            });
          });
        })
        .catch(e => {
          console.error(e);
        });
    }

    function eliminarSector(idSector) {
      const parametros = new FormData();
      parametros.append("operacion", "eliminar");
      parametros.append("idsector", idSector);

      fetch(`../../controllers/sector.controller.php`, {
        method: 'POST',
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datosRecibidos => {
          console.log(datosRecibidos);
          GetSector();
        })
        .catch(e => {
          console.error(e);
        });
    }


    document.getElementById("boton_eliminar").addEventListener("click", () => {
        GetSector();
        const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminarSector'));
      modalEliminar.show();
    });

    document.getElementById("equipoAsector").addEventListener("click", () => {
      mostrarModalEquipoAsector();
    });

    document.addEventListener("DOMContentLoaded", function() {
          var usuarioInput = document.getElementById("usuario");

          usuarioInput.value = "<?php echo $_SESSION['nombres'] . ' ' . $_SESSION['apellidos']; ?>";
      });

  function getCategorias(){

    const parametros = new FormData();
    parametros.append("operacion", "listar");

    fetch(`../../controllers/categoria.controller.php`, {
        method: "POST",
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
          datos.forEach(element => {
            const tagOption = document.createElement("option")
            tagOption.value = element.idcategoria
            tagOption.innerText = element.categoria
            $("#categoria").appendChild(tagOption);

          });
        })
        .catch(e => {
          console.error(e);
        });
  }
  getCategorias();

  function getMarcas(){

    const parametros = new FormData();
    parametros.append("operacion", "listar");

    fetch(`../../controllers/marca.controller.php`, {
        method: "POST",
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
          datos.forEach(element => {
            const tagOption = document.createElement("option")
            tagOption.value = element.idmarca
            tagOption.innerText = element.marca
            $("#marca").appendChild(tagOption);

          });
        })
        .catch(e => {
          console.error(e);
        });
  }
  getMarcas();

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
            $("#sector").appendChild(tagOption);

          });
        })
        .catch(e => {
          console.error(e);
        });
    }
    getSector();

    const equipoAsector = document.getElementById("equipoAsector");

    function mostrarModalEquipoAsector() {
      const ModalEquipoAsector = new bootstrap.Modal(document.getElementById('ModalEquipoAsector'));
      ModalEquipoAsector.show();
    }

  function añadirEquipo_Sector() {
    const parametros = new FormData();
    parametros.append("operacion", "registrarEquipos_Sector");
    parametros.append("idcategoria", $("#categoria").value);
    parametros.append("idmarca", $("#marca").value);
    parametros.append("modelo_equipo", $("#modelo").value);
    parametros.append("numero_serie", $("#num_serie").value);
    parametros.append("idsector", $("#sector").value);
    parametros.append("idusuario", idusuario);
    parametros.append("imagen", $("#imagen").files[0]);
    parametros.append("descripcion", $("#descripcion").value);

    fetch(`../../controllers/sector.controller.php`, {
      method: "POST",
      body: parametros
    })
      .then(respuesta => {
        if (!respuesta.ok) {
          throw new Error(`Error en la solicitud: ${respuesta.status}`);
        }
        return respuesta.json();
      })
      .then(datos => {
        if (datos.idmantenimiento_sector > 0) {
          alert(`Usuario registrado con ID: ${datos.idmantenimiento_sector}`)
          $("#form-equiposAsector").reset();
        }
      })
      .catch(e => {
        console.error(e);
      });
}



document.getElementById("guardarEquipo_Sector").addEventListener("click", () => {
        if (confirm("¿Está seguro de guardar?")) {
          añadirEquipo_Sector();
        }
    });

    


});









</script>

</body>

</html>