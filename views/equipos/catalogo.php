<?php

require_once "../sidebar/sidebar.php";
?>

    <div class="height-100 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="m-4">
              <h1 class="fw-bolder d-inline-block"><i class="bi bi-bar-chart-steps"></i> LISTA DE EQUIPOS</h1>
            </div>
            <hr>
          </div>
        </div>
      </div>
      
      <!-- FILTROS -->
      <div class="row">
        <div class="col-md-4 mt-2" style="margin-left: 2rem;">    
          <form id="form-busqueda">
            <div class="input-group">
              <input type="text" id="busqueda" class="form-control" placeholder="Buscar por número de serie" required>
              <button type="submit" class="btn btn-secondary">Buscar</button>
            </div>
          </form>
        </div>
        <!-- offset-md-$ genera un espacio entre columnas -->
        <div class="col-md-2 offset-md-3 mt-2">
          <div>
            <select name="marcaS" class="form-select"id="marcaFiltro">
              <option value="0">Marcas</option>
                <!-- RENDER MARCAS -->
            </select>
          </div>
        </div>
        <div class="col-md-2 mt-2">
          <select name="categoriasS" class="form-select" id="categoriasFiltro">
            <option value="0">Categorias</option>
              <!-- RENDER CATEGORIAS -->
          </select>
        </div>
      </div>

      <!-- RESUTADOS -->
      <div class="row">
        <div class="col-md-2 mt-2 mb-2" style="margin-left: 2rem;">
          <div class="input-group">
            <span class="input-group-text">Marcas:</span>
            <input type="text" class="form-control" id="marcasCal" readonly>
          </div>
        </div>
        <div class="col-md-2 mt-2 mb-2">
          <div class="input-group">
            <span class="input-group-text">Modelos:</span>
            <input type="text" class="form-control" id="modelosCal" readonly>
          </div>
        </div>
        <div class="col-md-2 mt-2 mb-2">
          <div class="input-group">
            <span class="input-group-text">Categorias:</span>
            <input type="text" class="form-control" id="categoriasCal" readonly>
          </div>
        </div>
      </div>

      <!-- CATALOGO -->
        <div class="" style="background-color: #DEE3E3;">

          <!-- RENDER CARD -->
          <div class="row" id="card">
                
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
    document.addEventListener("DOMContentLoaded", () => {

      function $(id){
        return document.querySelector(id);
      }

      const cardEquipo = $("#card");

      let Equipos = null;  //variable que alacena todos los equipos

      let EqMarcasF = null; //varibale que almacena los equipos filtrados por marcas

      let EqCategoriaF = null; //varibale que almacena los equipos filtrados por categorias y marcas

      let marcaSeleccionada = $("#marcaFiltro").value;

      /* let categoriaSeleccionada = $("#categoriasFiltro").value; */

      function calcularCantidad(equipos){

        const Marcas      = new Set(equipos.map(equipo => equipo.idmarca));
        const Modelos     = new Set(equipos.map(equipo => equipo.modelo_equipo));
        const Categorias  = new Set(equipos.map(equipo => equipo.idcategoria));

        const cantidadMarca       = Marcas.size;
        const cantidadModelos     = Modelos.size;
        const cantidadCategorias  = Categorias.size;

        $("#marcasCal").value     = cantidadMarca;
        $("#modelosCal").value    = cantidadModelos;
        $("#categoriasCal").value = cantidadCategorias;

        generarCardsArray(equipos);
      }

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
              
              $("#marcaFiltro").appendChild(tagOption); 
              });
            }
          })
          .catch(e => {
            console.error(e);
          });
      }

      //Generamos cards a partir de un conjunto de datos
      function generarCardsArray(varibleRender){
        
        if(varibleRender){

          cardEquipo.innerHTML ="";
 
          varibleRender.forEach(element => {

            const url = element.imagen ? element.imagen : "noImage.jpg";

            let newCard = ``;

            newCard = `
              <div class="col-md-3 m-4">
                <div class="card">
                  <div class="card-header">
                    <strong>Categoría : </strong>${element.categoria}
                  </div>
                  <div class="card-body">
                    <div>
                      <img src="../../images/${url}" style="height: 10rem; width: 12rem;" alt="${element.modelo_equipo}">
                    </div>
                    <div>
                    <strong>Nº serie : </strong>${element.numero_serie}
                    <br>
                      <strong>Marca : </strong>${element.marca}
                      <br>
                      <strong>Modelo : </strong>${element.modelo_equipo}
                      <br>
                      <strong>Descripción : </strong>${element.descripcion}
                      </div>
                  </div>
                  <div class="card-footer text-end">
                    <a href="../datasheet/datasheet.php?obtener=${element.idequipo}" type="button" class="btn btn-outline-dark" title="Especificaciones técnicas">Ver más ..</a>
                    <a href="../sectores/detalle_sector.php?sector=${element.idsector}&nombre=${element.sector}" type="button" class="btn rounded-circle" title="Ubicar equipo"><i class="fa-solid fa-location-dot" style="font-size: 1.5em;"></i></a>
                  </div>
                </div>
              </div>
            `;
            cardEquipo.innerHTML += newCard;
          });
        }else{
          let cardError= ``;
          
          cardError = `
            <div class="alert alert-danger" role="alert">
              <h4 class="alert-heading">Tenemos problemas</h4>
                <p>Intentalo más tarde</p>
                <hr>
            <p class="mb-0">Ocurrió un error al cargar los datos</p>
          </div>
          `;
          cardEquipo.innerHTML =cardError;
        }

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
              
              $("#categoriasFiltro").appendChild(tagOption); 
              });
            }
        });  
      }

      function listarEquipos(){
        
        const parametros = new FormData();

        parametros.append("operacion","listar");

        fetch(`../../controllers/equipo.controller.php`,{
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data =>{
            console.log(data);

            Equipos = data;

            calcularCantidad(Equipos);            

            generarCardsArray(Equipos);
            
          })
          .catch(e =>{
            console.error(e)
          });
      }

      function filtrarPorMarca(idmarcaIN){

        if( $("#marcaFiltro").value == 0){
          listarEquipos();
        }else{
          EqMarcasF = Equipos.filter(equipo => equipo.idmarca == idmarcaIN);
  
          console.log(EqMarcasF);
          calcularCantidad(EqMarcasF);
        }
      }

      function filtrarPorCategoria(idcategoriaIN){
        EqCategoriaF = Equipos.filter(equipo =>equipo.idcategoria == idcategoriaIN);

        console.log(EqCategoriaF);
        calcularCantidad(EqCategoriaF);
      }

      function filtroDoble(listaFiltrada,idcategoriaIN){

        if($("#categoriasFiltro").value == 0){
          listarEquipos();
        }else{

          if($("#marcaFiltro").value == 0 ){
            filtrarPorCategoria(idcategoriaIN);
          }else{
            EqCategoriaF = listaFiltrada.filter(lista => lista.idcategoria == idcategoriaIN);
    
            console.log(EqCategoriaF);
  
            if(EqCategoriaF.length == 0){
              
              console.log("no hay resultados");
              let cardError= ``;
          
              cardError = `
                <div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading">Tenemos problemas</h4>
                    <p>Intentalo más tarde</p>
                    <hr>
                  <p class="mb-0">Ocurrió un error al cargar los datos</p>
                </div>
              `;
              cardEquipo.innerHTML =cardError;
            }
            calcularCantidad(EqCategoriaF);
          }
        }

      }

      //Generamos un card a partir de un objeto en específico
      function buscarEquipoCard(numserie){

        cardEquipo.innerHTML ="";
        let equiposEncontrados = false;
        Equipos.forEach(element => {
        
          if(element.numero_serie == numserie ){
            if(element.estado == 1){

              equiposEncontrados = true;

              //LIMPIAMOS LOS CONTADORES
                $("#marcasCal").value     = "";
                $("#modelosCal").value    = "";
                $("#categoriasCal").value = "";
    
                console.log(element);
                const url = element.imagen ? element.imagen : "noImage.jpg";
    
                let newCard = ``;
    
                newCard = `
                  <div class="col-md-3 m-4">
                    <div class="card">
                      <div class="card-header">
                        <strong>Marca : </strong>${element.marca}
                      </div>
                      <div class="card-body">
                        <div>
                          <img src="../../images/${url}" style="height: 10rem; width: 12rem;" alt="${element.modelo_equipo}">
                        </div>
                        <div>
                          <strong>Categoría : </strong>${element.categoria}
                          <br>
                          <strong>Descripción : </strong>${element.descripcion}
                          <br>
                          <strong>Modelo : </strong>${element.modelo_equipo}
                          <br>
                          <strong>Nº serie : </strong>${element.numero_serie}
                        </div>
                      </div>
                      <div class="card-footer text-end">
                        <a href="../datasheet/datasheet.php?obtener=${element.idequipo}" type="button" class="btn btn-success">Ver más ..</a>
                        <a href="../sectores/detalle_sector.php?sector=${element.idsector}&nombre=${element.sector}" type="button" class="btn rounded-circle"><i class="bi bi-geo-alt-fill bi-2x"></i></a>
                        </div>
                    </div>
                  </div>
                `;
                cardEquipo.innerHTML += newCard;     
            }
          }
        });

        if(!equiposEncontrados){              
          let cardError= ``;
      
          cardError = `
            <div class="alert alert-danger" role="alert">
              <h4 class="alert-heading">No encontramos el equipo</h4>
                <p>N° de serie no registrado</p>
                <hr>
              <p class="mb-0">Asegurese de haber escrito el N° de serie correcto</p>
            </div>
          `;
          cardEquipo.innerHTML =cardError;
        }
      }
      
      $("#form-busqueda").addEventListener("submit",(event) => {
        event.preventDefault();
        const numeroSerie = $("#busqueda").value;
        buscarEquipoCard(numeroSerie);

       });

      $("#marcaFiltro").addEventListener("change",() =>{
        const idmarca = $("#marcaFiltro").value;
        filtrarPorMarca(idmarca);
      })
      
      $("#categoriasFiltro").addEventListener("change",() =>{
        const idcategoria = $("#categoriasFiltro").value;
        filtroDoble(EqMarcasF,idcategoria);
        
      })

      
      obtenerCategorias();
      obtenerMarcas();
      listarEquipos();
      
    });
  </script>
</body>

</html>