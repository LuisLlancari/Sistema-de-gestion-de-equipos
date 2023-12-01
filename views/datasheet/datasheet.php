<?php

require_once "../sidebar/sidebar.php";

?>  
    <div class="height-100 bg-light">
        <div class="m-4">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading">Información adicional</h4>
              <hr>
              <p class="mb-0" id="descripcion">--</p>
            </div>
            
            <div class="row">
                
                <div class="col-md-2">

                </div>

                <div class="col-md-12">

                    <!-- CRONOGRANA -->
                    <div>
                        <div class="bg-secondary text-white text-center">
                            <h1>Cronograma</h1>
                        </div>
                        <!-- tabla -->
                        
                        <!-- MENSAJE ERROR -->
                        <div id="CronogramaError"></div>
                        
                        <table class="table table-sm table-striped"  id="tabla-cronograma">
                            <colgroup>
                            <col width="18%"> <!-- Tipo tipo_mantenimiento -->
                            <col width="10%"> <!-- Estado -->
                            <col width="10%"> <!-- Fecha programada -->
                            
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Tipo de matenimiento</th>
                                <th>Estado</th>
                                <th>Fecha programada</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
                        </tbody>
                    </table>        
                    <!-- fin tabla -->
                    </div>

                    <!-- DATASHEET -->
                    <div>
                        <div class="bg-secondary text-white">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="m-2">
                                        <button id="registrarData" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modalId">Registrar</button>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="text-center">
                                        <h1>Especificaciones del equipo</h1>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 m-4">
                                <img id="visor1" src="" style="max-width: 100%;" alt="">
                            </div>

                            <!-- RENDER DATASHEET -->
                            <div class="col-md-6 m-4" id="datasheet">
                                <div id="datasheetError"></div>
                                <table class = "table table-sm table-striped" id="tabla-datasheet">
                                    <colgroup width="10%">
                                    <colgroup width="20%">
                                    <colgroup width="40%">
                                    <colgroup width="30%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th><i class="bi bi-list-task"></i></th>
                                            <th>Claves</th>
                                            <th>Valores</th>
                                            <th id="operaciones">Operaciónes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
  </main>

  
  <!-- Modal -->
  <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header bg-success text-light">
                        <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                            <button type="button" id="cerrar-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <form action="" id="datasheet-form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-2">
                            <label for="clave" class="form-label">Clave</label>
                            <input type="text" class="form-control" id="clave" autofocus>
                        </div>
                        <div class="mb-2">
                            <label for="valor" class="form-label">Valor</label>
                            <textarea name="valor" class="form-control" id="valor" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  
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
  <script>

    document.addEventListener("DOMContentLoaded", () => {
        
        function $(id){
            return document.querySelector(id);
        }
        // almacenamos el id del cuerpo de la tabla
        const tabla = $("#tabla-cronograma tbody")
        
        //id del equipo(dato obtenido de la solicutud get)
        const idEquipoObt = new URLSearchParams(window.location.search).get("obtener");
        console.log(idEquipoObt);

        //obtjto o lugar que contiene los elementos asíncronos
        const tablaDatashet = $("#tabla-datasheet tbody");

        /* variable donde guardamos los datos del equipo, obtenidos  de la consulta  */
        let datosDatasheet = null;

        /* vairable donde guardamos el id obtenido en ele render de datasheet(data-iddatashet) */
        let dataid = null 

        /* VARIABLE BANDERA */

        let varBandera = false; 

        const CronogramaError   = $("#CronogramaError");

        const datasheetError    = $("#datasheetError");

        function validarUsuario(){

            if($("#rolObt").textContent !== "ADMINISTRADOR"){

                const botonesEditar = document.querySelectorAll(".boton-render");
                
                botonesEditar.forEach(botonEditar => {

                    botonEditar.style.display ="none";
                });

                $("#operaciones").classList.add("d-none");
            }

        }
        function obtenerDatasheet(idequipoIN){

            const parametros = new FormData();

            parametros.append("operacion","listar");
            parametros.append("idequipo",idequipoIN);

            fetch(`../../controllers/datasheet.controller.php`,{
                method: "POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data =>{
                    console.log(data);

                    datosDatasheet = data;

                    if(datosDatasheet.length > 0){
                        
                        tablaDatashet.innerHTML = "";
                        datasheetError.innerHTML = ``;

                        let numFila = 1;
                        data.forEach(element => {
                            let nuevaTabla = ``;

                            nuevaTabla = `
                                <td>${numFila}</td>
                                <td>${element.clave}</td>
                                <td>${element.valor}</td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm boton-render editar" data-id="${element.iddatasheet}" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-outline-danger btn-sm boton-render eliminar" data-id="${element.iddatasheet}"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            `;
                            numFila++;

                            tablaDatashet.innerHTML += nuevaTabla;
                        });
                        validarUsuario();
                    }else{
                        datasheetError.innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Especificaciones no registradas</h4>
                            <p>Revise el equipo y agregue data técnica</p>
                        </div>
                        `;                        
                    }
                })
                .catch(e => {
                    console.error(e)
                });
        }

        function eliminarDatasheet(iddatasheetIn){

            const parametros = new FormData();

            parametros.append("operacion","eliminar");
            parametros.append("iddatasheet",iddatasheetIn);

            fetch(`../../controllers/datasheet.controller.php`,{
                method: "POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data => {
                    toast("El registro se eliminó con exito");
                    obtenerDatasheet(idEquipoObt);
                    tablaDatashet.innerHTML = ``;
                })
                .catch(e => {
                    console.error(e);
                    alertError("No se logró eliminar el registro","Ocurrió un error","Intentelo después");
                });
        }

        function filtrarData(iddatasheetIn){

            datosDatasheet.forEach(element => {
                
                if(element.iddatasheet == parseInt(iddatasheetIn)){
    
                    $("#clave").value = element.clave;
                    $("#valor").value = element.valor;
                    console.log("filtrardata");
                }
            });

        }

        function actualizarDatasheet(iddatasheet){
            
            const parametros = new FormData();

            parametros.append("idequipo",idEquipoObt);
            parametros.append("clave",$("#clave").value);
            parametros.append("valor",$("#valor").value);

            if(varBandera){

                parametros.append("operacion","modificar");
                parametros.append("iddatasheet",iddatasheet);
            }else{
                
                parametros.append("operacion","registrar");
            }


            fetch(`../../controllers/datasheet.controller.php`,{
                method: "POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data => {

                    toast("Se actualizó con exito");
                    obtenerDatasheet(idEquipoObt); // Funcion para volver a listar
                    $("#datasheet-form").reset();   // funcion para reinicar modal, en tu caso seria algo como: $("#micaja").reset();
                    //y aqui harias lo que te digo para cerrar el modal algo como:
                    $("#cerrar-modal").click();//$("boton-cerrar").click();

                    varBandera = false;

                })
                .catch(e => {
                    console.error(e);
                    alertError("No se guardaron los cambios","Ocurrió un error", "vuelva a intentarlo");
                });
        }

        function listar_cronograma(equipoid){
          const parametros = new FormData();
          parametros.append("operacion","listar_cronograma_id");
          parametros.append("idequipo",equipoid);

          fetch(`../../controllers/cronograma.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {

                console.log(datos);
                tabla.innerHTML = '';
               if(datos.length >0){
                
                datos.forEach(element => {
                    
                    let nuevafila =``;
                        nuevafila = `
                      <tr>
                        <td>${element.tipo_mantenimiento}</td>
                        <td>${element.estado}</td>
                        <td>${element.fecha_programada}</td>
                        </td>
                      </tr>
                      `;
                      tabla.innerHTML += nuevafila;
                });
               }else{
                CronogramaError.innerHTML = 
                `
                <div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading">Revisión no programada</h4>
                  <p>Asigne mantenimiento para este equipo según sea su condición</p>
                </div>
                `;
               }
    

            } )
            .catch(e =>  {
              console.error(e);
            });               
        }

        function obtenerEquipo(idequipoIN){
            const parametros = new FormData();

            parametros.append("operacion","obtenerEquipo"),
            parametros.append("idequipo",idequipoIN),

            fetch(`../../controllers/equipo.controller.php`,{
                method: "POST",
                body: parametros,
            })
                .then(result => result.json())
                .then(data =>{
                    console.log(data);
                    if(data){
                        
                        const url = data.imagen ? data.imagen : "noImage.jpg"; 

                        $("#descripcion").innerText = data.descripcion;
                        $("#visor1").setAttribute("src","../../images/" + url);
                        obtenerDatasheet(data.idequipo);
                        

                    }
                })
                .catch(e => {
                    console.error(e);
                });
        }

        $("#datasheet").addEventListener("click",(event) =>{

            dataid = event.target.dataset.id;
            
            varBandera = true;

            if(event.target.classList.contains("editar")){

                console.log(dataid);

                $("#modalTitleId").innertext = "Actualizar datos";
                filtrarData(dataid);

            }else if(event.target.classList.contains("eliminar")){
                console.log(dataid)

                mostrarPregunta("Por favor confirme","¿Desea eliminar este registro?",() =>{
                    eliminarDatasheet(dataid);
                });
            }
        });

        $("#datasheet-form").addEventListener("submit",(event) => {
            event.preventDefault();
            actualizarDatasheet(dataid);
        });

        $("#registrarData").addEventListener("click", () =>{
            $("#modalTitleId").innerText = "Registrar datos";
            $("#datasheet-form").reset();
        });

        listar_cronograma(idEquipoObt);
        obtenerEquipo(idEquipoObt);
        
    });
  </script>
</body>

</html>