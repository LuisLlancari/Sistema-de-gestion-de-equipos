<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">

      <div class="row">
        <div class="row bg-secondary text-center">
            <div class="col-md-1">
              <button type="button" class="btn btn-success m-2" id="informe-categoriasEqui"><i class="fa-regular fa-file-pdf"></i></button>
            </div>
            <div class="col-md-11">
              <div class="text-light">
                <h1 class="">Categoría de los equipos</h1>
              </div>
            </div>
        </div>
        <div style="height: 40rem; margin-left:25%">
          <canvas id="cateogoriasEquipos"></canvas>
        </div>
      </div>
      <div class="m-2">     
        <div class="row bg-secondary text-center">
            <div class="col-md-1">
            <button type="button" class="btn btn-success m-2" id="informe-estadosEqui"><i class="fa-regular fa-file-pdf"></i></button>
            </div>
            <div class="col-md-11">
              <div class="text-light">
                <h1 class="">Estado de los equipos</h1>
              </div>
            </div>
        </div>
        <div style="height: 30rem; margin-left:15%">
          <canvas id="estadosEquipos"></canvas>
        </div>
      </div>
      <div class="m-2">
        <div class="row bg-secondary text-center">
          <div class="col-md-1">
            <button type="button" class="btn btn-success m-2" id="informe-sectoresEqui"><i class="fa-regular fa-file-pdf"></i></button>
            </div>
            <div class="col-md-11">
              <div class="text-light">
                <h1 class="">Equipos por sectores</h1>
              </div>
            </div>
        </div>
      </div>
      <div class="m-2">
        <div class="row bg-secondary text-center">
          <div class="col-md-1">
            <button type="button" class="btn btn-success m-2" id="informe-estadosCro"><i class="fa-regular fa-file-pdf"></i></button>
            </div>
            <div class="col-md-11">
              <div class="text-light">
                <h1 class="">Estado de los cronogramas</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="m-2">
      <div class="row bg-secondary text-center">
          <div class="col-md-1">
            <button type="button" class="btn btn-success m-2" id="informe-estadosMan"><i class="fa-regular fa-file-pdf"></i></button>
            </div>
            <div class="col-md-11">
              <div class="text-light">
                <h1 class="">Estado de los matenimientos</h1>
              </div>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () =>{


      function $(id){
        return document.querySelector(id);
      }

      const graficoDona   = $("#cateogoriasEquipos");
      const graficoBarras = $("#estadosEquipos");

      const coloresBarras = [
        "rgba(32, 223, 29,0.5)",
        "rgba(17, 101, 230,0.5)",
        "rgba(230, 27, 17, 0.5)"
      ];

      function generarGraficoDona(datos){

        new Chart(graficoDona, {
          type: 'doughnut',
          data: {
            labels: datos.map(contador => contador.categoria),
            datasets: [{
              label: 'Cantidad de equipos',
              data: datos.map(contador => contador.cantidad),
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }

      function generarGraficoBarras(datos){
      
        new Chart(graficoBarras, {
          type: 'bar',
          data: {
            labels: datos.map(contador => contador.estado),
            datasets: [{
              label: 'Estados',
              data: datos.map(contador => contador.cantidad),
              backgroundColor: coloresBarras,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
      
      function obtenerCategoriasEquipos(){

        const parametros = new FormData();
        parametros.append("operacion","categoriasEquiposGR");

        fetch(`../../controllers/equipo.controller.php`,{
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {
            console.log(data);
            generarGraficoDona(data);
          })
          .catch(e => {
            console.error(e)
          });
      }

      function obtenerEstadosequipos(){

        const parametros = new FormData();
        parametros.append("operacion","estadosequiposGR");

        fetch(`../../controllers/equipo.controller.php`,{
          method : "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {
            console.log(data);

            generarGraficoBarras(data);
          })
          .catch();
      }
  
  
      obtenerCategoriasEquipos();
      obtenerEstadosequipos();

});
</script>
</body>

</html>