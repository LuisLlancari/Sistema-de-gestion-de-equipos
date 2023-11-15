<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">
        <h1>cronograma</h1>
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
      document.addEventListener("DOMContentLoaded",() => {
        function $(id){return document.querySelector(id)};


        function listar_cronogramas(){
          const parametros = new FormData();
          parametros.append("operacion" ,"listar_cronograma");

          fetch(`../../controllers/cronograma.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);
            })
            .catch(e =>  {
              console.error(e);
            });               
        }

        listar_cronogramas();
        


    });
      
    </script>
</body>

</html>