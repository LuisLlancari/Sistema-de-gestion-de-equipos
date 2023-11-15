<?php

session_start();
if(!isset($_SESSION["status"]) || !$_SESSION["status"]){
    header("Location:../../index.php");

}

$accesos = [
    "ADMIN" =>[
        "cronograma"    => [],
        "datasheet"     => [],
        "equipos"       => ["equipos-catalogo","equipos-listar"],
        "usuario"      => ["usuario"],
        "graficos"      => ["index"]
    ],
    "ASIST" =>[
        "cronograma"    => [],
        "datasheet"     => [],
        "equipos"       => ["equipos-catalogo"],
        "graficos"      => ["index"]
        ]
    ];
?>
<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <!-- INCONOS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="body-pd">

  <main>

    <nav class ="navbar">
        <header class="header" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="">
            <span class="text-uppercase"><?=$_SESSION["apellidos"]?>,</span> <span><?=$_SESSION["nombres"]?> -</span><span id="rolobt"><?=$_SESSION["rol"]?></span> 
        </div>
        <div class="header_img"> 
                
                <?php
                    echo "<img src='../../images/".$_SESSION["avatar"]."' alt=''>";
                    
                ?> 
            </div>
        </header>
        <div class="l-navbar" id="sidebar">
            <nav class="nav">
                <div>
                <a href="#" class="nav_logo"><span class="nav_logo-name">SISCOMPU</span></a>
                <div class="nav_list"> 
                    <?php
                        $categorias = $accesos[$_SESSION["rol"]];
                        foreach ($categorias as $categoria => $subcategoria) {
                            
                            if($categoria != "equipos" && $categoria != "graficos" && $categoria != "usuario"){
                            echo "
                            <li>
                                    <a href='../{$categoria}/{$categoria}.php' class='nav_link'><span class='nav_name'>{$categoria}</span></a>
                                    "; 
                            }
                                if($categoria == "equipos" || $categoria == "graficos" || $categoria == "usuario"){
                                    echo "
                                    <a href='#' class='nav_link'><span class='nav_name'>{$categoria}</span></a>
                                    ";
                                }                       
                                

                                if($subcategoria){
                                    echo "<div class='m-3'>";
                                    foreach ($subcategoria as $item) {
                                        # code...
                                        echo "
                                        <li>
                                            <a href='../{$categoria}/{$item}.php' class='nav_link'><span class='nav_name'>{$item}</span></a> 
                                        </li>
                                        ";
                                    }
                                    echo "
                                    </div>
                                    ";
                                }

                            echo "
                            </li>
                            ";

                    
                        }
                    ?>
                    <!--  
                        <li>
                            <a href="#" class="nav_link active"><span class="nav_name">Dashboard</span></a> 
                        </li>
                        <li>
                            <a href="#" class="nav_link"><span class="nav_name">Usuarios</span></a>
                        </li>
                        <li>
                            <a href="../equipos/equipos-catalogo.php" class="nav_link"><span class="nav_name">Equipos</span></a>
                            <ul>
                                <li>
                                    </a> <a href="../equipos/equipos-listar.php" class="nav_link"><span class="nav_name">Lista</span></a>
                                </li>
                            </ul> 
                        </li>
                        <li>
                            <a href="#" class="nav_link"><span class="nav_name">Bookmark</span> </a> 
                        </li>
                        <li>
                            <a href="#" class="nav_link"><span class="nav_name">Files</span> </a> 
                        </li>
                        <li>
                            <a href="#" class="nav_link"><span class="nav_name">Stats</span> </a> 
                        </li> -->
                    </div>
                </div> 
                <a href="../../controllers/usuario.controller.php?operacion=destroy" class="nav_link"> <span class="nav_name">SignOut</span></a>
            </nav>
        </div>
        <!--Container Main start-->


    </nav>