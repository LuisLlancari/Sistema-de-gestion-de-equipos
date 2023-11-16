<?php

if(isset($_GET['obtener'])){

    $idequipo = $_GET['obtener'];

    echo "<script>const idObt =".json_encode($idequipo)." </script>";
}

require_once "../sidebar/sidebar.php";

?>  
    <div class="height-100 bg-light">
        <div class="m-4">

            
            <div class="row">
                
                <div class="col-md-2">
                    <div class="d-grid">
                        <button id="registrarData" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modalId">Registrar data</button>
                        <button id="modificarData" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modalId">Modificar data</button>
                        <a href="../cronograma/cronograma.php" type="button" class="btn btn-primary mb-2">Cronograma</a>
                    </div>
                </div>

                <div class="col-md-10">

                    <!-- CRONOGRANA -->
                    <div>
                        <div class="bg-secondary text-white text-center">
                            <h1>Cronograma</h1>
                        </div>
<<<<<<< HEAD
                        <!-- tabla -->
                        <!-- fin tabla -->
=======


                        <table class="table table-sm table-striped  "  id="tabla-cronograma">
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

                        <!-- <div class="row">
                            <div class="col-md-5 m-4">
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                            </div>
                            <div class="col-md-5 m-4">
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Valor</label>
                                    <h6>Clave</h6>
                                </div>
                            </div> -->
>>>>>>> 4cf9cbe93e56ee5fe29c77cee67bece6e30ce7c4
                    </div>

                    <!-- DATASHEET -->
                    <div>
                        <div class="bg-secondary text-white text-center">
                            <h1>Datasheet</h1>
                        </div>
                        <div class="row">
                            <div class="col-md-4 m-4">
                                <img src="../../images/User-Avatar-Profile-Transparent-Clip-Art-PNG.png" style="max-width: 100%;" alt="">
                            </div>

                            <!-- RENDER DATASHEET -->
                            <div class="col-md-5 m-4" id="datasheet">

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
        const datoslabel = $("#datasheet");

        /* variable donde guardamos los datos del equipo, obtenidos  de la consulta  */
        let datosDatasheet = null;

        /* vairable donde guardamos el id obtenido en ele render de datasheet(data-iddatashet) */
        let dataid = null 

        /* VARIABLE BANDERA */

        let varBandera = false; 

        function getdatasheet(idequipo){

            const parametros = new FormData();

            parametros.append("operacion","listar");
            parametros.append("idequipo",idequipo);

            fetch(`../../controllers/datasheet.controller.php`,{
                method: "POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data =>{
                    console.log(data);

                    datosDatasheet = data;
                    if(datosDatasheet.length > 0){

                        datoslabel.innerHTML = "";

                        data.forEach(element => {
                            let datosNuevos = ``;

                            datosNuevos = `
                                <div class="mb-2">
                                    <label for="valor" class="form-label clave">${element.clave} :</label><span class="valor">${element.valor}</span>
                                    <button class="btn btn-info editar" data-id="${element.iddatasheet}" data-bs-toggle="modal" data-bs-target="#modalId">Editar</button>
                                    <button class="btn btn-danger eliminar" data-id="${element.iddatasheet}">Eliminar</button>
                                </div>
                            `;

                            datoslabel.innerHTML += datosNuevos;
                        });
                    }else{
                        let h6Error = ``;

                        h6Error = `
                        <h6 class="bg-danger">No encontramos datos</h6>
                        `;
                        datoslabel.innerHTML = h6Error;
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
                    getdatasheet(idEquipoObt);
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
                    getdatasheet(idEquipoObt);
                    reiniciarModal();

                })
                .catch(e => {
                    console.error(e);
                    alertError("No se guardaron los cambios","Ocurrió un error", "vuelva a intentarlo");
                });
        }

<<<<<<< HEAD
        function listar_cronograma(){
            const parametros = new FormData();
          parametros.append("operacion","listar_cronograma_id");
          parametros.append("idequipo",1);
=======
        function listar_cronograma(equipoid){
          const parametros = new FormData();
          parametros.append("operacion"     ,"listar_cronograma_id");
          parametros.append("idequipo"     ,equipoid);
>>>>>>> 4cf9cbe93e56ee5fe29c77cee67bece6e30ce7c4

          fetch(`../../controllers/cronograma.controller.php`,{
            method: "POST",
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
<<<<<<< HEAD
                console.log(datos);
            })
            .catch(e =>  {
              console.error(e);
            });             
        }

        listar_cronograma();

=======

               // poner un if
            tabla.innerHTML = '';
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
    

            } )
            .catch(e =>  {
              console.error(e);
            });               
        }

    
>>>>>>> 4cf9cbe93e56ee5fe29c77cee67bece6e30ce7c4

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

                mostrarPregunta("Por favor confirme","¿Desea eliminar este registro?")
                    .then((result) =>{eliminarDatasheet(dataid)});
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
        getdatasheet(idEquipoObt);
    });
  </script>
</body>

</html>