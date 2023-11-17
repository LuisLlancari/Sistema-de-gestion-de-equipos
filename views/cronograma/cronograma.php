<?php

require_once "../sidebar/sidebar.php";
?>  


    <div class=" bg-light">
        <h1>cronograma</h1>
        <!-- Button trigger modal -->
    </div>

      <!-- CONTENIDO DEL CALENDARIO -->
    <div style="max-width: 900px; margin:auto" id="calendar"></div>
      <!-- CONTENIDO DEL CALENDARIO -->
    

    <!-- Modal -->
    <div class="modal fade" id="modal-cronograma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h1 class="modal-title fs-5" id="titulo-modalC"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="descripcion"> </div>
            <form action="" autocomplete="off" id="form-cronograma">
            <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="equipo" class="form-label">equipo</label>
                  <input type="text" class="form-control" id="equipo" required>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="T-mantenimiento" class="form-label">tipo mantenimiento</label>
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
              <label for="fecha" class="form-label">fecha programada</label>
              <input type="date" class="form-control" id="fecha" required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="hora" class="form-label">hora programada</label>
              <input type="time" class="form-control" id="hora" required>
            </div>
          </div>
            
            <div class="mb-3">
              <label for="estado" class="form-label">estado</label>
              <select name="" id="estado" class="form-select" required>
              <option value="">Seleccion:</option>
              <option value="pendiente">pendiente</option>
              <option value="cancelado">cancelado</option>
             </select>     
            </div>

          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="agregar">Enviar</button>
            <button type="button" class="btn btn-danger"  id="borrar">Borrar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            estado: evento.estado
            // Agrega más propiedades si es necesario
          })),
          color:"green",
          textColor:"white"
        }],
        
        dateClick: function(info) {
          $('#form-cronograma').reset();
          $("#titulo-modalC").innerText = "Agregar Cronograma";
          $('#fecha').value = info.dateStr;
          modalregistro.show();
        },
        eventClick: function(info ) {
          bandera = false;
       
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

          modalregistro.show();
          
          
          
          // change the border color just for fun
          info.el.style.borderColor = 'red';
        }
        });
        calendar.render();
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
        //   En esta variable se concatena la fecha y la hora para enviarlos a 
        //   la base de datos como Datetime
        var  idcronograma  = $('#agregar').getAttribute('cronogramaid');
        var fechaHora = $("#fecha").value+" "+$("#hora").value;

        const parametros = new FormData();
        parametros.append("tipo_mantenimiento",$("#T-mantenimiento").value);
        parametros.append("estado"            ,$("#estado").value);
        parametros.append("fecha_programada"  ,fechaHora);

        if(bandera){
          parametros.append("operacion"         ,"registrar_cronograma");
          parametros.append("equipo"            ,$("#equipo").value);

        }else{
          parametros.append("operacion","modificar_cronograma");
          parametros.append("idcronograma" ,idcronograma);
        } 


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
            console.log(datos);
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


    });
      
    </script>
</body>

</html>