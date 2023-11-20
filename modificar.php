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
 <div class="row mt-5">
  <div class="col-md-4"></div>
  <div class="col-md-4">




    
    <div class="container mt-3">
      <form action="" autocomplete="off" id="form-producto">
    <div class="card">
      <div class="card-header bg-primary text-light">
       Cambiar contraseña
      </div>
      <div class="card-body">
        
          <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contraseña" required>
          </div>

          <div class="mb-3">
            <label for="rep_contraseña" class="form-label">Vuelva escribir la contraseña</label>
            <input type="password" class="form-control" id="rep_contraseña" required>
          </div>
           
      </div>
      <div class="card-footer text-muted">
        <button class="btn btn-primary" type="button" id="guardar_contraseña">Cambiar contraseña</button>
      </div>
    </div>
   </form>
  </div> <!-- container -->

        </div>

        <div class="col-md-4"></div>
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