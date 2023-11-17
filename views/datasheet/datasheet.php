<?php

if(isset($_GET['obtener'])){

    $idequipo = $_GET['obtener'];

    echo "<script>const idObt =".json_encode($idequipo)." </script>";
}

require_once "../sidebar/sidebar.php";

?>  
    <div class="height-100 bg-light">
        <div class="m-4">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading">Hoja de información</h4>
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


                        <table class="table table-sm table-striped"  id="tabla-cronograma">
                            <colgroup>
                                <col width="18%"> <!-- Categoria -->
                                <col width="10%"> <!-- Descripción -->
                                <col width="10%"> <!-- Precio -->

                            </colgroup>
                            <thead>
                                <tr>
                                <th>tipo de matenimiento</th>
                                <th>estado</th>
                                <th>fecha programada</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
                            </tbody>
                        </table>        
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
                                        <h1>Datasheet</h1>
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
                                <table class = "table table-sm table-striped" id="tabla-datasheet">
                                    <colgroup width="10%">
                                    <colgroup width="20%">
                                    <colgroup width="40%">
                                    <colgroup width="30%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Claves</th>
                                            <th>Valores</th>
                                            <th>Operaciónes</th>
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
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                            <button type="button" id="cerrar-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <form action="" id="datasheet-form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-2">
                            <label for="clave" class="form-label">Clave</label>
                            <input type="text" class="form-control" id="clave">
                        </div>
                        <div class="mb-2">
                            <label for="valor" class="form-label">Valor</label>
                            <textarea name="valor" class="form-control" id="valor" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
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
        const idEquipoObt = idObt
        console.log(idEquipoObt);

        //obtjto o lugar que contiene los elementos asíncronos
        const tablaDatashet = $("#tabla-datasheet tbody");

        /* variable donde guardamos los datos del equipo, obtenidos  de la consulta  */
        let datosDatasheet = null;

        /* vairable donde guardamos el id obtenido en ele render de datasheet(data-iddatashet) */
        let dataid = null 

        /* VARIABLE BANDERA */

        let varBandera = false; 

        function validarUsuario(){

            if($("#rolObt").textContent !== "ADMIN"){

                const botonesEditar = document.querySelectorAll(".boton-render");
                
                botonesEditar.forEach(botonEditar => {

                    botonEditar.style.display ="none";
                });
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

                        let numFila = 1;
                        data.forEach(element => {
                            let nuevaTabla = ``;

                            nuevaTabla = `
                                <td>${numFila}</td>
                                <td>${element.clave}</td>
                                <td>${element.valor}</td>
                                <td>
                                    <button class="btn btn-info boton-render editar" data-id="${element.iddatasheet}" data-bs-toggle="modal" data-bs-target="#modalId">Editar</button>
                                    <button class="btn btn-danger boton-render eliminar" data-id="${element.iddatasheet}">Eliminar</button>
                                </td>
                            `;
                            numFila++;

                            tablaDatashet.innerHTML += nuevaTabla;
                        });
                        validarUsuario();
                    }else{
                        let h6Error = ``;

                        h6Error = `
                        <h6 class="bg-danger text-white">No encontramos datos</h6>
                        `;
                        $("#datasheet").innerHTML = h6Error;
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

        function reiniciarModal(){
            varBandera = false;
            $("#clave").value = "";
            $("#valor").value = "";
            $("#cerrar-modal").click();

            console.log(varBandera);
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
                    obtenerDatasheet(idEquipoObt);
                    reiniciarModal();

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

                tabla.innerHTML = '';
               // poner un if
               if(datos.length >0){

                   let nuevafila =``;
                       nuevafila = `
                     <tr>
                       <td>${datos.tipo_mantenimiento}</td>
                       <td>${datos.estado}</td>
                       <td>${datos.fecha_programada}</td>
                       </td>
                     </tr>
                     `;
                     tabla.innerHTML += nuevafila;
               }else{
                tabla.innerHTML = 
                `
                    <h6 class="bg-danger text-light">No hay resultados</h6>
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

            console.log(varBandera);
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
            reiniciarModal();
        });

        listar_cronograma(idEquipoObt);
        obtenerEquipo(idEquipoObt);
        
    });
  </script>
</body>

</html>