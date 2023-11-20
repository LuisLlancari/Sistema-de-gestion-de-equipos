<!doctype html>
<html lang="en">

<head>
  <title>modificar cambiar_contraseña</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>


<div class="container-fluid vh-100 d-flex align-items-center">
  <div class="card mx-auto" style="max-width: 850px;">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="./test/modalCONTRASEÑA.jpeg" style="width: 300%; height: 100%;" class="img-fluid" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h2 class="card-title">Cambiar contraseña</h2>
          <hr>
          <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña Nueva:</label>
            <input type="password" class="form-control" id="contraseña" required autofocus>
          </div>

          <div class="mb-3">
            <label for="rep_contraseña" class="form-label">Confirmar la contraseña nueva:</label>
            <input type="password" class="form-control" id="rep_contraseña" required>
          </div>
        </div>
        <div class="mt-auto card-footer d-flex justify-content-end">
        <button class="btn btn-primary" type="button" id="guardar_contraseña">Aplicar cambios</button>
        </div>
      </div>
    </div>
  </div>
</div>




  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    document.addEventListener("DOMContentLoaded",() => {
      function $(id){return document.querySelector(id)}
      const searchParams = new URLSearchParams(window.location.search)
      const idusuario = parseInt(searchParams.get('idusuario'));



      function cambiar_contraseña(){

        const parametros= new FormData();
        parametros.append("operacion"     ,"cambiar_contraseña");          
        parametros.append("idusuario"     , idusuario);                    
        parametros.append("claveacceso"   ,$("#contraseña").value);                    


        fetch(`./controllers/usuario.controller.php`,{
        method: "POST",
        body: parametros
        })
        .then(respuesta => respuesta.json())
        .then(datos =>{ 
        })
        .catch(e => {
        console.error(e);
        });
      }

      $('#guardar_contraseña').addEventListener('click', function() {
        var confirmacion = confirm("¿Estás seguro de que deseas continuar?");
        if (confirmacion) {
          
          if($("#contraseña").value == $("#rep_contraseña").value){
              cambiar_contraseña();
              window.location.href = `./index.php`;
            }else{
              console.log("Las contraseñas no coinciden");
              
            }

        } else {
          alert("El usuario ha cancelado.");
        }


        // cambiar_contraseña();
      });
    


    });
  </script>
</body>

</html>