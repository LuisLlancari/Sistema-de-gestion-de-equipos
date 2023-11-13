<!doctype html>
<?php

require_once "../sidebar/sidebar.php";
?>
    <div class="height-100 bg-light">
      <!-- BOTÓN -->
        <div class="btn-sidebar toggled" id="menu-toggle">
            <span class="fas fa-bars"></span>
        </div>
      <div>
        <div class="text-center m-4">
          <h1 class="fw-bolder">Lista de equipos</h1>
        </div>
        <div class="row">
          <!-- LATERAL IZQUIERDO -->
          <div class="col-md-3" style="background-color: #7BEBEF; opacity: 0.5;">
            <div class="m-4">
              <div>
                <label for="filtro" class="form-lable">Filtro: </label>
                <input type="range" class="form-range" name="filtro" id="filtroV" value="1000" min="0" max="5000">
              </div>
              <hr>
              <form action="" id="from-filtro">
                <div>
                  <label for="busqueda" class="form-label">Busqueda</label>
                  <input type="text" class="form-control" id="busqueda">
                </div>
                <div class="d-grid mt-2">
                  <button type="submit" class="btn btn-success" id="buscar">Buscar</button>
                </div>
              </form>
              <hr>
              <div>
                <h6>Resultados</h6>
                <div class="input-group mt-2">
                  <span class="input-group-text" id="nombreValor"> Valor</span>
                  <input type="text" class="form-control"  id="cantidadValor">
                </div>
                <div class="input-group mt-2">
                  <span class="input-group-text" id="nombreValor"> Valor</span>
                  <input type="text" class="form-control"  id="cantidadValor">
                </div>
                <div class="input-group mt-2">
                  <span class="input-group-text" id="nombreValor"> Valor</span>
                  <input type="text" class="form-control"  id="cantidadValor">
                </div>
              </div>
            </div>
          </div>
  
          <!-- LATERAL DERECHO -->
          <div class="col-md-9" style="background-color: #DEE3E3; opacity: 0.5;">

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
  <script src="../../js/sidebar.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      function $(id){
        return document.querySelector(id);
      }

      const cardEquipo = $("#card");

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

            if(data){

              cardEquipo.innerHTML ="";

              data.forEach(element => {

                let newCard = ``;

                newCard = `
                <div class="col-md-3 m-4">
                    <div class="card">
                      <div class="card-header">
                        <strong>Marca : </strong>${element.marca}
                      </div>
                      <div class="card-body">
                        <div>
                          <img src="../../images/${element.imagen}" alt="${element.modelo_equipo}">
                        </div>
                        <div>
                          <strong>Modelo : </strong>${element.modelo_equipo}
                          <br>
                          <strong>Nº serie : </strong>${element.numero_serie}
                        </div>
                      </div>
                      <div class="card-footer">
                        <a href="../datasheet/datasheet.php?obtener=${element.idequipo}" type="button" class="btn btn-success">Ver más ..</a>
                      </div>
                    </div>
                </div>
                `;
                cardEquipo.innerHTML += newCard;
              });

            }else{
              cardEquipo = `
                <div class="alert alert-primary" role="alert">
                  <h4 class="alert-heading">Tenemos problemas</h4>
                    <p>Intentalo más tarde</p>
                    <hr>
                <p class="mb-0">Ocurrió un error al cargar los datos</p>
              </div>
              `;
            }
          })
          .catch(e =>{
            console.error(e)
          });
      }

      listarEquipos();
      
    });
  </script>
</body>

</html>