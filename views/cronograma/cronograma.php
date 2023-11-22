<?php

require_once "../sidebar/sidebar.php";
?>  
  <head>
    <!-- <link href="/website/css/uicons-bold-rounded.css"rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="m-4">
          <h1 class="fw-bolder d-inline-block"><i class="bi bi-calendar-week"></i> CRONOGRAMA</h1>
        </div>
        <hr>
      </div>
    </div>
  </div>

      <!-- CONTENIDO DEL CALENDARIO -->
    <div style="max-width: 900px; margin:auto" id="calendar"></div>
      <!-- CONTENIDO DEL CALENDARIO -->
    

    <!-- Modal -->
    <div class="modal fade" id="modal-cronograma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h1 class="modal-title fs-5 text-center text-white" id="titulo-modalC"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="descripcion"> </div>
            <form action="" autocomplete="off" id="form-cronograma">
            <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="equipo" class="form-label">Equipo - N°serie:</label>
                  <input type="text" class="form-control" id="equipo" required>
                </div>
                      
                <div class="col-md-6 mb-3">
                  <label for="T-mantenimiento" class="form-label">Tipo mantenimiento:</label>
                  <select name="" id="T-mantenimiento" class="form-select" required>
                  <option value="">Seleccion:</option>
                  <option value="reparacion">Reparación</option>
                  <option value="actualizacion">Actualización</option>
                  <option value="preventivo">Preventivo</option>
                 </select>     
                </div>
              </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="fecha" class="form-label">Fecha programada:</label>
                <input type="date" class="form-control" id="fecha" required>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="hora" class="form-label">Hora programada:</label>
                <input type="time" class="form-control" id="hora" required>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="estado" class="form-label">Estado:</label>
              <select name="" id="estado" class="form-select" required>
              <option value="">Seleccion:</option>
              <option value="completado">completado</option>
              <option value="pausado">Pausado</option>
              <option value="cancelado">cancelado</option>
             </select>     
            </div>
            
            <div class="mb-3">
              <label for="comentario" class="form-label">Comentario:</label>
              <textarea class="form-control" id="comentario" rows="3" required ></textarea>
              <div class="invalid-feedback"> Ingresar comentario. </div>
            </div>

          </form>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-outline-success flex-fill" id="agregar"><i class="fi-sr-eye"></i>Guardar</button>
             <button type="button" class="btn btn-outline-danger flex-fill"  id="borrar">Borrar</button>
            <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>


  <!-- Bootstrap JavaScript Libraries -->


  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.js"></script>


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

      var modalregistro = new bootstrap.Modal($('#modal-cronograma'));

      var bandera = true;

      function calendario(datos){

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          // initialView: 'dayGridMonth',
        locale: 'es', 
        headerToolbar:{
          right :'prev,next today',
          center:'title',
          left:'dayGridMonth, timeGridWeek, timeGridDay,miBoton'
        },
        eventSources:[{
          
          events: datos.map(evento => ({
            id: evento.idcronograma.toString(), // Convierte a cadena para evitar problemas con FullCalendar
            title: evento.modelo_equipo,
            start: evento.fecha_programada,
            description: evento.tipo_mantenimiento,
            estado: evento.estado,
            comentario: evento.descripcion
            // Agrega más propiedades si es necesario
          })),
          color:"green",
          textColor:"white"
        }],
        
        dateClick: function(info) {
          bandera = true;

          var fechaActual = new Date();

          // var año = fechaActual.getFullYear();
          // var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
          // var dia = fechaActual.getDate().toString().padStart(2, '0');

          // // Construir la cadena de fecha en formato "YYYY-MM-DD"
          // var fechaFormateada = `${año}-${mes}-${dia}`;

          // console.log("fechaActual",fechaActual.getTime());
          // console.log("date",info.date.getTime());
          // let nFechaActual=fechaActual.setHours(0, 0, 0, 0);
          // console.log("nFechaActual",nFechaActual);

          // if(info.date == fechaActual){
          //   console.log("no puedes ingresar")


          // }
          // else{
          //   console.log("puedes ingresar")

          // }


          preparar_formulario(info);
         
        },
        eventClick: function(info ) {
          bandera = false;
          preparar_formulario(info);

          // change the border color just for fun
          // info.el.style.borderColor = 'red';
        }
        });
        calendar.render();
      }

      function customReset() {

          $('#agregar').style.display = "block";
          $('#borrar').style.display = "block";
          $("#equipo").removeAttribute('disabled');
          $("#estado").removeAttribute('disabled');
          $("#comentario").removeAttribute('disabled');
          $('#T-mantenimiento').removeAttribute('disabled');
          $('#fecha').removeAttribute('disabled');
          $("#hora").removeAttribute('disabled');
          $('#agregar').removeAttribute('disabled');
          $('#borrar').removeAttribute('disabled');

      }
      
      function preparar_formulario(info){
        $('#form-cronograma').reset();
        customReset();
          if(bandera){
         
            $("#equipo").removeAttribute('disabled');
            $("#equipo").removeAttribute('readOnly');
            $("#comentario").setAttribute('disabled','true');
            $("#estado").setAttribute('disabled','true');
            $("#comentario").setAttribute('readOnly','true');
            $("#titulo-modalC").innerText = "Agregar Cronograma";
            $('#fecha').value = info.dateStr;
            modalregistro.show();

          }else{

 
            $("#equipo").setAttribute('disabled','true');
            $("#equipo").setAttribute('readOnly','true');
            $("#estado").removeAttribute('disabled');
            $("#comentario").setAttribute('disabled','true');
            $("#comentario").setAttribute('readOnly','true');
            
            var fechaObj = new Date(info.event.start);

            // Obtener la fecha en formato "YYYY-MM-DD"
            var fechaFormateada = fechaObj.toISOString().split('T')[0];
            // Obtener la hora en formato "HH:mm:ss"
            var horaFormateada = fechaObj.toTimeString().split(' ')[0];

            $("#titulo-modalC").innerText = "Editar Cronograma";
            $('#equipo').value = info.event.title;
            $('#T-mantenimiento').value =info.event._def.extendedProps.description;
            $('#fecha').value = fechaFormateada;
            $('#hora').value =  horaFormateada;
            $('#estado').value =info.event._def.extendedProps.estado;
            $('#agregar').setAttribute('cronogramaid',info.event.id);
            $('#borrar').setAttribute('cronogramaid',info.event.id);



            if(info.event._def.extendedProps.estado=="completado"){
               $("#equipo").setAttribute('disabled','true');
               $("#estado").setAttribute('disabled','true');
               $("#comentario").setAttribute('disabled','true');
               $('#T-mantenimiento').setAttribute('disabled','true');
               $('#fecha').setAttribute('disabled','true');
               $("#hora").setAttribute('disabled','true');
               $("#comentario").value =info.event._def.extendedProps.comentario;
 

            
                $('#agregar').style.display = "none";
                $('#borrar').style.display = "none";
             }
 
            modalregistro.show();

          }
          
      }


      function listar_cronogramas(){
        const parametros = new FormData();
        parametros.append("operacion" ,"listar_cronograma");

        fetch(`../../controllers/cronograma.controller.php`,{
          method: "POST",
          body : parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
            calendario(datos);
          })
          .catch(e =>  {
            console.error(e);
          });               
      }
      

      function registrar_cronograma(){

 
        var comentarioFormulario  = $('#comentario').value;
        if(comentarioFormulario.trim().length==0 && $("#estado").value=="completado"){
          $('#comentario').classList.add("is-invalid");
          console.log("comentarioFormulario => ",comentarioFormulario)
          return;
        }


        //   En esta variable se concatena la fecha y la hora para enviarlos a 
        //   la base de datos como Datetime
        var  idcronograma  = $('#agregar').getAttribute('cronogramaid');
        var fechaHora = $("#fecha").value+" "+$("#hora").value;

        const parametros = new FormData();
        parametros.append("tipo_mantenimiento"  ,$("#T-mantenimiento").value);
        parametros.append("fecha_programada"    , fechaHora);
 
        if(bandera){
          parametros.append("operacion"         ,"registrar_cronograma");
          parametros.append("equipo"            ,$("#equipo").value);
        }
        else{
          parametros.append("operacion",       "modificar_cronograma");
          parametros.append("estado",          $("#estado").value);
          parametros.append("idcronograma",    idcronograma);
          parametros.append("comentario",      $('#comentario').value);
          parametros.append("idusuario",       1);

        } 
        fetch(`../../controllers/cronograma.controller.php`,{
          method: "POST",
          body : parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
            $('#comentario').classList.remove("is-invalid");
            $('#form-cronograma').reset();
            modalregistro.hide();
            listar_cronogramas();

          })
          .catch(e =>  {
            console.error(e);
          });               
      }


      function eliminar_cronogramas(){

        var  idcronograma  = $('#borrar').getAttribute('cronogramaid');
        const parametros = new FormData();
        parametros.append("operacion" ,"eliminar_cronograma");
        parametros.append("idcronograma" ,idcronograma);

        fetch(`../../controllers/cronograma.controller.php`,{
          method: "POST",
          body : parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
            $('#form-cronograma').reset();
            modalregistro.hide();
            listar_cronogramas();

          })
          .catch(e =>  {
            console.error(e);
          });     
      }


      listar_cronogramas();
     

      $('#agregar').addEventListener('click', function(){
          registrar_cronograma();
        });
     

      $('#borrar').addEventListener('click', function(){
        eliminar_cronogramas();    
      });
      
      $("#estado").addEventListener("change" , (event) =>{

          let estado = $('#estado').value ;
          $("#comentario").setAttribute('disabled','true');
          $("#comentario").setAttribute('readOnly','true');
         

          if( estado == "completado"){
            $("#comentario").removeAttribute('disabled');
            $("#comentario").removeAttribute('readOnly');
            
          }

        });

    });
      
    </script>
</body>

</html>