<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">
        Bienvenido
    </div>
  
      
      <div style="width: 50%;">
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
          <button type='button' class="btn btn-sm bg-success" id='mostrar'>Mostrar datos</button>
          <button type='button' class="btn btn-sm mx-3">Mostrar datos</button>
        </div>
      </div> 
      <div style="width: 50%;"> 
    <br>
    <br>

    <!-- GRAFICOS -->
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
          <button type='button' class="btn btn-sm mx-3">Mostrar datos</button>
        </div>
      </div> 
    <!-- GRAFICOS -->

    
    </div>
        



  </main>
  <footer>
    <!-- place footer here -->
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script src="../../js/sidebar.js"></script>


  <script>
    
    // const obt = document.querySelector("#rolObt");
    // console.log(obt.textContent);
    // if(obt.textContent == "ADMIN"){
    //   console.log("eres un administrador")
    // }


 
    
    function $(id= ``){
      return document.querySelector(id)
    }
    const grafCronograma = $("#grafCronograma");
    const grafMantenimiento = $("#grafMantenimiento");


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
      
      
    const graficoCronograma= new Chart(grafCronograma, {  
      type: 'doughnut',
      data : graficoCronogramaData
    });
     

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
             
            graficoCronograma.data.datasets[0].data = datos.map(item => item.cantidad_tipo);
            graficoCronograma.data.labels = datos.map(item => item.estado);
            graficoCronograma.update();

          })
          .catch(e =>  {
            console.error(e);
          });               
    }



    listarGraficoCronograma();
    listarGraficoMantenimiento();


    $('#mostrar').addEventListener('click', function(){
      listarGraficoMantenimiento();
    });
    
    $('#cronogram').addEventListener('click', function(){

      listarGraficoCronograma();
    });

    </script>
</body>

</html>