<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">

      <div class="m-2">
        <h1 class="bg-secondary text-light text-center">Categoría de los equipos</h1>
        <div style="height: 30rem; margin-left:15%">
          <canvas id="cateogoriasEquipos"></canvas>
        </div>
      </div>
      <div class="m-2">
        <h1 class="bg-secondary text-light text-center">Estado de los equipos</h1>
        <div style="height: 30rem; margin-left:15%">
          <canvas id="estadosEquipos"></canvas>
        </div>
      </div>
      <div class="m-2">
        <h1 class="bg-secondary text-light text-center">Equipos por sectores</h1>
      </div>
      <div class="m-2">
        <h1 class="bg-secondary text-light text-center">Estado de los cronogramas</h1>
      </div>
      <div class="m-2">
        <h1 class="bg-secondary text-light text-center">Estado de los mantemietos</h1>
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