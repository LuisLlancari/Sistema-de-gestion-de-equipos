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




      
      

     


  



    








    </script>
</body>

</html>