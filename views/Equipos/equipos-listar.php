<?php

require_once "../sidebar/sidebar.php";
?>  
    <div class="height-100 bg-light">

        <div class="m-4">
            <div class="m-2">
                <div class="row">

                    <div class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                              <div class="col-md-4" style="background-color:#E5CF01;">
                                <!-- <img src="Image Source" class="img-fluid rounded-start" alt="Card title"> -->
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Categorias</h5>
                                  <p class="card-text" id="cantidadCategorias">--</p>
                                  <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>

                    <di v class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                              <div class="col-md-4" style="background-color:#2422E5;" >
                                <!-- <img src="" class="img-fluid rounded-start" alt="Card title"> -->
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Marcas</h5>
                                  <p class="card-text" id="cantidadMarcas">--</p>
                                  <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                                </div>
                              </div>
                            </div>
                          </div>
                    </di>

                    <div class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                              <div class="col-md-4" style="background-color:#0FE606;" >
                                <!-- <img src="Image Source" class="img-fluid rounded-start" alt="Card title"> -->
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Modelos</h5>
                                  <p class="card-text" id="cantidadModelos">--</p>
                                  <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 m-4">
                        <label for="categoriaFiltro" class="form-label">Categorias</label>
                        <select class="form-select" name="categoriaFiltro" id="categoria">
                            <option value="0">Todos</option>
                        </select>
                        <div class="mt-2">
                          <button type="button" id="registrarEquipo" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">Nuevo equipo</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <table class="table table-striped" id="tabla-equipos">
                        <colgroup>
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                            <col width="15%%">
                            <col width="10%">
                            <col width="15%">
                            <col width="15%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Nº serie</th>
                                <th>Imagen</th>
                                <th>Usuario</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- MODAL-EQUIPOS -->

    <!-- Button trigger modal -->
    
    <!-- Modal -->
    <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                      <button type="button" id="cerrar-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
          <div class="modal-body">
            <form action="" id="formulario-equipo">
              <div class="container-fluid">
                <div class="mb-2">
                  <label for="categoria" class="form-label">Categoria</label>
                  <select class="form-select" name="categoria" id="categoriaEdit">
                    <option value="">Seleccione</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label for="marca" class="form-label">Marca</label>
                  <select class="form-select" name="marca" id="marcaEdit">
                    <option value="">Seleccione</option>
                  </select>
                </div>

<!--                 ESTE LABEL SOLO ES DE PRUEBA YA QUE EL USUARIO SE DEBE DE GUARDAR DE FORMA AUTOMÁTICA SIN ESCRIBIR
                <div class="mb-2">
                  <label for="usuario" class="form-label">Usuario</label>
                  <input type="text" class="form-control" name="usuario" id="usuarioEdit">
                </div> -->
           
                <div class="mb-2">
                  <label for="modelo" class="form-label">Modelo</label>
                  <input type="text" class="form-control" name="modelo" id="modeloEdit">
                </div>
                <div class="mb-2">
                  <label for="numero_serie" class="form-label">Numero de serie</label>
                  <input type="text" class="form-control" name="numero_serie" id="serieEdit">
                </div>
                <div class="mb-2">
                  <label for="imagen" class="form-label">Imagen</label>
                  <input type="file" class="form-control" name="imagen" id="imagenEdit" accept=".jpg">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" id="guardar-datos"class="btn btn-primary">Guardar</button>
              </div>
            </form>
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            function $(id){
                return document.querySelector(id);
            }

            let categorias = null;

            let equipos = null;

            let equipoId = null;

            let varBandera = false;


            function getInfo(equiposARR){

              const Categorias  = new Set(equiposARR.map(contador => contador.categoria));
              const Modelos     = new Set(equiposARR.map(contador => contador.modelo_equipo));
              const Marcas      = new Set(equiposARR.map(contador => contador.marca));

              const cantidadModelo      = Modelos.size;
              const cantidadCategorias  = Categorias.size;
              const cantidadMarcas      = Marcas.size;

              console.log("la cantidad de modelos son :", cantidadModelo);
              console.log("y estos son los modelos :", Modelos);

              console.log("la cantidad de categorias son :", cantidadCategorias);
              console.log("y estos son las categorias :", Categorias);

              console.log("la cantidad de marcas son :", cantidadMarcas);
              console.log("y estos son las marcas :", Marcas);

              $("#cantidadModelos").innerHTML     = cantidadModelo;
              $("#cantidadMarcas").innerHTML      = cantidadMarcas;
              $("#cantidadCategorias").innerHTML  = cantidadCategorias;
            }

            function cardInfoLimpiar(){
              $("#cantidadCategorias").innerHTML ="";
              $("#cantidadMarcas").innerHTML ="";
              $("#cantidadModelos").innerHTML ="";
            }


            function getCategorias(){

                const parametros = new FormData();

                parametros.append("operacion","listar");

                fetch(`../../controllers/categoria.controller.php`,{
                    method : "POST",
                    body: parametros
                })
                    .then(result => result.json())
                    .then(data => {
                        //console.log(data);

                        categorias = data

                        categorias.forEach(element => {
                            
                          const tagOption = document.createElement("option");
                          tagOption.value = element.idcategoria;
                          tagOption.innerText = element.categoria;

                          $("#categoria").appendChild(tagOption);

                        });
                    })
                    .catch(e =>{
                        console.error(e);
                    });
            }

            function getCategoriasModal(){

                const parametros = new FormData();

                parametros.append("operacion","listar");

                fetch(`../../controllers/categoria.controller.php`,{
                    method : "POST",
                    body: parametros
                })
                    .then(result => result.json())
                    .then(data => {
                        //console.log(data);

                        categorias = data

                        categorias.forEach(element => {
                            
                          const tagOption = document.createElement("option");
                          tagOption.value = element.idcategoria;
                          tagOption.innerText = element.categoria;

                          $("#categoriaEdit").appendChild(tagOption);

                        });
                    })
                    .catch(e =>{
                        console.error(e);
                    });
            }


            function getMarcas(){

              const parametros = new FormData();

              parametros.append("operacion","listar");

              fetch(`../../controllers/marca.controller.php`,{
                method : "POST",
                body: parametros
              })
              .then(result => result.json())
              .then(data => {
              //console.log(data);

              data.forEach(element => {
            
              const tagOption = document.createElement("option");
              tagOption.value = element.idmarca;
              tagOption.innerText = element.marca;

              $("#marcaEdit").appendChild(tagOption);

                });
              })
              .catch(e =>{
                console.error(e);
              });
            }


            function getEquipos(){

                const parametros = new FormData();

                parametros.append("operacion","getEquipoCat");
                parametros.append("idcategoria",$("#categoria").value);


                fetch(`../../controllers/equipo.controller.php`,{
                    method : "POST",
                    body : parametros
                })
                    .then(result => result.json())
                    .then(data =>{
                        console.log(data);

                        equipos = data;

                        cardInfoLimpiar();
                        getInfo(equipos);

                        if(equipos){

                            const tabla = $("#tabla-equipos tbody");

                            tabla.innerHTML = "";

                            let numFila = 1;

                            equipos.forEach(element => {
                                let newTabla = ``;

                                newTabla = `
                                <td>${numFila}</td>
                                <td>${element.categoria}</td>
                                <td>${element.marca}</td>
                                <td>${element.modelo_equipo}</td>
                                <td>${element.numero_serie}</td>
                                <td>
                                <a href="#" data-id="${element.idequipo} data-img="${element.imagen}">Ver Imagen</a>
                                </td>
                                <td>${element.nombres}</td>
                                <td>
                                    <a type="button" class="btn btn-info editar" data-id="${element.idequipo}" data-bs-toggle="modal" data-bs-target="#modalId">Editar</a>
                                    <a type="button" class="btn btn-danger eliminar" data-id="${element.idequipo}">Eliminar</a>
                                </td>
                                `;
                                numFila ++;
                            tabla.innerHTML += newTabla;
                            });
                        }
                    })
                    .catch(e => {
                        console.error(e);
                    });
            }

            function reinciciarModal(){

              varBandera = false;

              $("#categoriaEdit").value = "";
              $("#marcaEdit").value     = "";
              $("#modeloEdit").value    = "";
              $("#serieEdit").value     = "";
              $("#imagenEdit").value    = "";
              $("#cerrar-modal").click();

              console.log(varBandera);
            }

            function iniciarModal(){
              getCategoriasModal();
              getMarcas();
            }

            function actualizarDatos(idEquipo){

              const parametros = new FormData();

              
              parametros.append("idcategoria",$("#categoriaEdit").value);
              parametros.append("idmarca",$("#categoriaEdit").value);
              parametros.append("modelo_equipo",$("#modeloEdit").value);
              parametros.append("numero_serie",$("#serieEdit").value);
              parametros.append("imagen",$("#imagenEdit").files[0]);
              
              if(varBandera){
                parametros.append("operacion","modificar");
                parametros.append("idequipo",idEquipo);
              }else{
                parametros.append("operacion","registrar");
              }
              fetch(`../../controllers/equipo.controller.php`,{
                method : "POST",
                body :parametros
              })
                .then(result => result.json())
                .then(data => {
                  toast("Se actualizó con exito");
                  reinciciarModal();
                  getEquipos();
                })
                .catch(e => {
                  console.error(e),
                  alertError("No se guardaron los cambios","Ocurrió un error", "vuelva a intentarlo");
                })
            }

            function filtrarDatos(idEquipo){

              equipos.forEach(element => {
                if(element.idequipo == idEquipo){
                  $("#categoriaEdit").value = element.idcategoria;
                  $("#marcaEdit").value     = element.idmarca;
                  $("#modeloEdit").value    = element.modelo_equipo;
                  $("#serieEdit").value     = element.numero_serie;
                  $("#imagenEdit").value    = element.imagen;
                }
              });
            }
            function eliminarEquipo(idEquipo){

              const parametros = new FormData();

              parametros.append("operacion","eliminar");
              parametros.append("idequipo",idEquipo);

              fetch(`../../controllers/equipo.controller.php`,{
                method: "POST",
                body: parametros
              })
                .then(result => result.json())
                .then(data => {
                  toast("El registro se eliminó con exito");
                  getEquipos();
                })
                .catch(e => {
                  console.error(e);
                  alertError("No se logró eliminar el registro","Ocurrió un error","Intentelo después");
                });
            }


            $("#categoria").addEventListener("change", getEquipos);

            $("#registrarEquipo").addEventListener("click",() =>{

              $("#modalTitleId").innerText = "Formulario de registro";
              reinciciarModal();
            });

            $("#tabla-equipos tbody").addEventListener("click",(event) => {

              equipoId = event.target.dataset.id;

              varBandera = true;

              console.log(varBandera);
              if(event.target.classList.contains("editar")){


                console.log(equipoId);

                filtrarDatos(equipoId);

              }else if(event.target.classList.contains("eliminar")){
                console.log(equipoId);
                mostrarPregunta("Por favor confirme","¿Desea eliminar este registro?")
                    .then((result) =>{eliminarEquipo(equipoId)});
              }
            });

            $("#formulario-equipo").addEventListener("submit", () =>{
              event.preventDefault();
              actualizarDatos(equipoId);
            });

            iniciarModal();
            getEquipos();
            getCategorias();
        });
    </script>
</body>

</html>