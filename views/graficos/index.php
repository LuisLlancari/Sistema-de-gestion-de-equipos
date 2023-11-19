<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">
        Bienvenido
    </div>

    <div style="width: 50%;">
    <canvas id="migrafico"></canvas>
    
  </div> 
  
  
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
    <button type='button' id='mostrar'>Mostrar datos</button>
 



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


    const coloresfondo =  ["#40E0D0", "#2c9c91",  "#207068",  "#13433e" ]
    const colores =       ["#13433e", "#207068",  "#2c9c91",  "#40E0D0"]



    const contexto = document.querySelector("#migrafico");

    const grafico = new Chart(contexto, {
          type: 'bar',
          data: {
            labels: [],
            datasets: [{
              label: "2023",
              data:[],
              borderColor: colores,
              backgroundColor: coloresfondo,
            }]
          },
          options:{
            scales:{
              y:{ beginAtzero: true  }
            }
          }
    });


    function $(id= ``){
      return document.querySelector(id)
    }

 



 



    function listar_cronogramas(){
        const parametros = new FormData();
        parametros.append("operacion" ,"listar_cronograma_grafico");
        parametros.append("fechainicio" ,$('#fechainicio').value);
        parametros.append("fechafin" ,$('#fechafin').value);

        fetch(`../../controllers/cronograma.controller.php`,{
          method: "POST",
          body : parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
             
            grafico.data.datasets[0].data = datos.map(item => item.cantidad_tipo);
            grafico.data.labels =           datos.map(item => item.tipo_mantenimiento);
            grafico.update();




          })
          .catch(e =>  {
            console.error(e);
          });               
    }

    listar_cronogramas()
    $('#mostrar').addEventListener('click', function(){
      listar_cronogramas();
    });

    </script>
</body>

</html>