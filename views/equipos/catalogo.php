<!doctype html>
<?php

require_once "../sidebar/sidebar.php";
?>
    <div class="height-100 bg-light">
      <div>
        <div class="text-start m-4 ">
          <h1 class>Lista de equipos</h1>
        </div>
          <!-- FILTROS -->
          <div class="row">
            <div class="col-md-2">
              <select name="marcaS" class="form-select"id="marcaS">
                <option value="0">Marcas</option>
                <option value="0">Marcas</option>
                <option value="0">Marcas</option>
              </select>
            </div>
            <div class="col-md-2">
              <select name="categoriasS" class="form-select" id="categoriasS">
                <option value="0">Categorias</option>
                <option value="0">Categorias</option>
                <option value="0">Categorias</option>
              </select>
            </div>
            <div class="col-md-6">
              <div class="input-group"></div>
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

                const url = data.imagen ? data.image : "noImage.jpg";

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
                      <div class="card-footer">
                        <a href="../datasheet/datasheet.php?obtener=${element.idequipo}" type="button" class="btn btn-success">Ver más ..</a>
                      </div>
                    </div>
                </div>
                `;
                cardEquipo.innerHTML += newCard;
              });

            }else{
              let cardError= ``;
              
              cardError = `
                <div class="alert alert-primary" role="alert">
                  <h4 class="alert-heading">Tenemos problemas</h4>
                    <p>Intentalo más tarde</p>
                    <hr>
                <p class="mb-0">Ocurrió un error al cargar los datos</p>
              </div>
              `;
              cardEquipo.innerHTML =cardError;
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