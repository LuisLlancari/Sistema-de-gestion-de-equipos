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
        <div style="height: 30rem; margin-left:15%">
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
    const ctx = document.getElementById('cateogoriasEquipos');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
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

  const ctx2 = document.getElementById('estadosEquipos');

new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
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
</script>
</body>

</html>