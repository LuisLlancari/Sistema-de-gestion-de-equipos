<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">

      <div class="row">
        <div class="row bg-secondary text-center">
            <div class="col-md-1">
              <button  type="button" class="btn btn-success m-2" id="informe-categoriasEqui"><i class="fa-regular fa-file-pdf"></i></button>
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
          <div style="height: 40rem; margin-left:25%">
            <canvas id="sectoresEquipo"></canvas>
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
          <div style="width: 40%; margin-left: 25%;"> 
            <canvas id="grafCronograma"></canvas>
              <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha Inicio:</label>
                    <input type="date" class="form-control" id="fechainiciograf" required value="2023-01-01">
                  </div>                  
                  <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha Fin:</label>
                    <input type="date" class="form-control" id="fechafingraf" required value="2023-12-31">
                  </div>
                </div>
                <button type='button' class="btn btn-sm bg-success" id='cronogram'>Mostrar datos</button>
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
        <div style="width: 50%; margin-left: 25%;">
          <canvas id="grafMantenimiento"></canvas>
              
              <div style="width: 50%;">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha Inicio:</label>
                    <input type="date" class="form-control" id="fechainicio" required value="2023-01-01">
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha Fin:</label>
                    <input type="date" class="form-control" id="fechafin" required value="2023-12-31">
                  </div>
                </div>
                <button type='button' class="btn btn-sm btn-success" id='mostrar'>Mostrar datos</button>
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

      let estadosEquipos = null;
      let categoriasEquipos = null;
      let sectoresEquipos = null;
      let estadosCronogramas = null;
      let estadosMatenimiento = null;

      const grafCronograma = $("#grafCronograma");
      const grafMantenimiento = $("#grafMantenimiento");
      const grDona   = $("#cateogoriasEquipos");
      const grBarras = $("#estadosEquipos");
      const grDonaSector = $("#sectoresEquipo");

      const coloresBarras = [
        "rgba(32, 223, 29,0.5)",
        "rgba(17, 101, 230,0.5)",
        "rgba(230, 27, 17, 0.5)"
      ];

     //datos del gráfico de cronograma
     let graficoCronogramaData = {
        labels: [],
        datasets: [
        {
            data: [],
            backgroundColor: [ "#FF6384","#09e644","#84FF63","#8463FF","#6384FF"],
            borderColor: "black",
            borderWidth: 2
        }]
      };

    //datos del gráfrico de cronograma
    let graficoMantenimientoData =  {
      labels: [],
      datasets: [{
        label: "2023 - 2024",
        data:[],
        borderColor: ["#09e644", "#1193b8",  "#f0d62e",  "#40E0D0"],
        backgroundColor: ["#09e644", "#1193b8",  "#f0d62e",  "#13433e" ],
      }]
    }

    let  graficoMantenimientoOptions={
      scales:{
        y:{ beginAtzero: true  }
      }
    }

    const graficoMantenimiento = new Chart(grafMantenimiento, {
      type: 'bar',
      data: graficoMantenimientoData,
      options:graficoMantenimientoOptions      
    });

    const graficoCronograma= new Chart(grafCronograma, {  
        type: 'doughnut',
        data : graficoCronogramaData
    });
       
    function listarGraficoMantenimiento(){
      const parametros = new FormData();
      parametros.append("operacion" ,"listar_mantenimiento_grafico");
      parametros.append("fechainicio" ,$('#fechainicio').value);
      parametros.append("fechafin" ,$('#fechafin').value);

      fetch(`../../controllers/mantenimiento.controller.php`,{
        method: "POST",
        body : parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
            estadosMatenimiento = datos;
          graficoMantenimiento.data.datasets[0].data = datos.map(item => item.cantidad_tipo);
          graficoMantenimiento.data.labels = datos.map(item => item.tipo_mantenimiento);
          graficoMantenimiento.update();

        })
        .catch(e =>  {
          console.error(e);
        });               
    }

    function listarGraficoCronograma(){
        const parametros = new FormData();
        parametros.append("operacion" ,"listar_cronograma_grafico");
        parametros.append("fechainicio" ,$('#fechainiciograf').value);
        parametros.append("fechafin" ,$('#fechafingraf').value);

        fetch(`../../controllers/cronograma.controller.php`,{
          method: "POST",
          body : parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
             
            estadosCronogramas = datos;

            graficoCronograma.data.datasets[0].data = datos.map(item => item.cantidad_tipo);
            graficoCronograma.data.labels = datos.map(item => item.estado);
            graficoCronograma.update();

          })
          .catch(e =>  {
            console.error(e);
          });               
    }
      
    function generarGrDona(datos){

      new Chart(grDona, {
        type: 'doughnut',
        data: {
          labels: datos.map(contador => contador.categoria),
          datasets: [{
            label: 'Cantidad de equipos',
            data: datos.map(contador => contador.cantidad),
            borderWidth: 1
          }]
        },
      });
    }

    function generarGrBarras(datos){
      
      new Chart(grBarras, {
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
      
    function generarGrDonaSector(datos){
      new Chart(grDonaSector, {
        type: 'doughnut',
        data: {
          labels: datos.map(contador => contador.sector),
          datasets: [{
            label: 'Cantidad de equipos',
            data: datos.map(contador => contador.equipos),
            borderWidth: 1
          }]
        },
      });
    }

    function generarGrDonaCro(datos){
      let datosEquipos = null;

      let graficoCronogramaData = {
        labels: [],
        datasets: [
        {
          data: [],
          backgroundColor: [ "#FF6384","#09e644","#84FF63","#8463FF","#6384FF"],
          borderColor: "black",
          borderWidth: 2
        }]
      };
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

          categoriasEquipos = data;
          generarGrDona(categoriasEquipos);
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

          estadosEquipos = data;

          generarGrBarras(estadosEquipos);
        })
        .catch(e => {
          console.error(e);
        });
    }

    function obtenerSectoresEquipos(){
      const parametros = new FormData();
      parametros.append("operacion","sectoresEquiposGR");

      fetch(`../../controllers/equipo.controller.php`,{
         method : "POST",
        body: parametros
      })
        .then(result => result.json())
        .then(data => {
          console.log(data);

          sectoresEquipos = data;

          generarGrDonaSector(sectoresEquipos);
        })
        .catch(e => {
          console.error(e);
        });
    }
      
    function EquiposCategoriaPDF(datos){
      const parametros = new FormData();
      parametros.append("operacion","pdfCategoriasEquipos");

      fetch(`../../pdf/PDF.php`,{
        method:"POST",
        body: parametros
      }) 
        .then(result => result.blob())
        .then(data => {
          const fileURL = URL.createObjectURL(data);
          window.open(fileURL); 
        })
        .catch(e => {
          console.error(e)
        });
    }

    function EquiposEstadoPDF(datos){
      const parametros = new FormData();
      parametros.append("operacion","pdfEstadosEquipos");

      fetch(`../../pdf/PDF.php`,{
        method:"POST",
        body: parametros
      })
        .then(result => result.blob())
        .then(data =>{
          const fileURL = URL.createObjectURL(data);
          window.open(fileURL);
        })
        .catch(e =>{
          console.error(e)
        });
    }

    function EquiposSectorPDF(datos){
      const parametros = new FormData();
      parametros.append("operacion","sectoresEquiposGR");

      fetch(`../../pdf/PDF.php`,{
        method: "POST",
        body: parametros
      })
        .then(result => result.blob())
        .then(data => {
          const fileURL = URL.createObjectURL(data);
          window.open(fileURL);
        })
        .catch(e => {
          console.error(e);
        });
    }

    function CronogramasEstadoPDF(datos){
      const parametros = new FormData();
      parametros.append("operacion","listar_cronograma_grafico");
      parametros.append("fechainicio",$("#fechainiciograf").value);
      parametros.append("fechafin",$("#fechafingraf").value);

      fetch(`../../pdf/PDF.php`,{
        method : "POST",
        body: parametros
      })
        .then(result => result.blob())
        .then(data => {
          const fileURL = URL.createObjectURL(data);
          window.open(fileURL);
        })
        .catch();
    }

    function MantenimientEstadoPDF(datos){

      const parametros = new FormData();
      parametros.append("operacion","listar_mantenimiento_grafico");
      parametros.append("fechainicio",$("#fechainicio").value);
      parametros.append("fechafin",$("#fechafin").value);

      fetch(`../../pdf/PDF.php`,{
        method: "POST",
        body: parametros
      })
        .then(result => result.blob())
        .then(data => {
          const fileURL = URL.createObjectURL(data);
          window.open(fileURL);
        })
        .catch(e =>{
          console.error(e)
        });
    }

    $("#informe-estadosMan").addEventListener("click",()=>{

      console.log(estadosMatenimiento);
      MantenimientEstadoPDF(estadosMatenimiento);
    });

    $("#informe-estadosCro").addEventListener("click",()=>{

      console.log(estadosCronogramas);
      CronogramasEstadoPDF(estadosCronogramas);
    });

    $("#informe-sectoresEqui").addEventListener("click", () => {

      console.log(sectoresEquipos);
      EquiposSectorPDF(sectoresEquipos);
    });

    $("#informe-categoriasEqui").addEventListener("click", () =>{
      console.log(categoriasEquipos);
      EquiposCategoriaPDF(categoriasEquipos);
    });

    $("#informe-estadosEqui").addEventListener("click", () => {
      console.log(estadosEquipos);
      EquiposEstadoPDF(estadosEquipos);
    });

    $('#mostrar').addEventListener('click', function(){
      listarGraficoMantenimiento();
    });
    
    $('#cronogram').addEventListener('click', function(){

      listarGraficoCronograma();
    });


      obtenerCategoriasEquipos();
      obtenerEstadosequipos();
      obtenerSectoresEquipos();
      listarGraficoCronograma();
      listarGraficoMantenimiento();



  });
</script>
</body>

</html>