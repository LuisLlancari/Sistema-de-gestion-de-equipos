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
                              <div class="col-md-4">
                                <img src="Image Source" class="img-fluid rounded-start" alt="Card title">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Cateogorias</h5>
                                  <p class="card-text"> --</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                              <div class="col-md-4">
                                <img src="Image Source" class="img-fluid rounded-start" alt="Card title">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Marcas</h5>
                                  <p class="card-text">--</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                              <div class="col-md-4">
                                <img src="Image Source" class="img-fluid rounded-start" alt="Card title">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Modelos</h5>
                                  <p class="card-text">--</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 m-4">
                        <label for="categoria" class="form-label">Categorias</label>
                        <select class="form-select" name="categoria" id="categoria">
                            <option value="0">Todos</option>
                        </select>
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
        document.addEventListener("DOMContentLoaded", () => {

            function $(id){
                return document.querySelector(id);
            }

            let categorias = null;

            function getCategorias(){

                const parametros = new FormData();

                parametros.append("operacion","listar");

                fetch(`../../controllers/categoria.controller.php`,{
                    method : "POST",
                    body: parametros
                })
                    .then(result => result.json())
                    .then(data => {
                        console.log(data);

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


            function getEquipos(){

                const parametros = new FormData();

                parametros.append("operacion","listar");


                fetch(`../../controllers/equipo.controller.php`,{
                    method : "POST",
                    body : parametros
                })
                    .then(result => result.json())
                    .then(data =>{
                        console.log(data);

                        if(data){

                            const tabla = $("#tabla-equipos tbody");

                            tabla.innerHTML = "";

                            let numFila = 1;

                            data.forEach(element => {
                                let newTabla = ``;

                                newTabla = `
                                <td>${numFila}</td>
                                <td>${element.categoria}</td>
                                <td>${element.marca}</td>
                                <td>${element.modelo_equipo}</td>
                                <td>${element.numero_serie}</td>
                                <td>${element.imagen}</td>
                                <td>${element.nombres}</td>
                                <td>
                                    <a type="button" class="btn btn-info editar" data-id="${element.idequipo}">Editar</a>
                                    <a type="button" class="btn btn-danger Eliminar" data-id="${element.idequipo}">Eliminar</a>
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

            getEquipos();
            getCategorias();
        });
    </script>
</body>

</html>