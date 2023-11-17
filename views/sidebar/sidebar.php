<?php

session_start();
if(!isset($_SESSION["status"]) || !$_SESSION["status"]){
    header("Location:../../index.php");

}

$accesos = [
    "ADMIN" =>[
        "sectores"      => ["inicio"],
        "cronograma"    => [],
        "equipos"       => ["catalogo","panel"],
        "usuario"       => ["usuario"],
        "graficos"      => ["index"],
        "sector"        => ["listar"],
    ],
    "ASIST" =>[
        "graficos"      => ["index"],
        "cronograma"    => [],
        "equipos"       => ["catalogo"]
        ]
    ];
?>
<!doctype html>
<html lang="en">

<head>
  <title>SISCOMPU</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <!-- Font Awesome icons (free version)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="body-pd">
  <main>
    <div class="sidenav">
        <header class="header" id="header">
            <div class="header_toggle"> 
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="">
                <span class="text-uppercase text start"><?=$_SESSION["apellidos"]?>,</span> <span><?=$_SESSION["nombres"]?> -</span><span id="rolobt"><?=$_SESSION["rol"]?></span> 
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
                    <div class="nav_list" id="navlist"> 
                    <a href="#about"><p></p>About</a>
                    
                    <?php
                    $categorias = $accesos[$_SESSION["rol"]];
                    foreach ($categorias as $categoria => $subcategoria) {
            
                        if($categoria != "equipos" && $categoria != "graficos" && $categoria != "usuario" && $categoria != "sector"){
                            echo "
                                <a href='../{$categoria}/{$categoria}.php' class='nav_link cat'><span class='nav_name'>{$categoria}</span></a>
                            "; 
                        }

                        if($categoria == "equipos" || $categoria == "graficos" || $categoria == "usuario" || $categoria == "sector"){
                            echo "
                                <a type ='button' href='#' class='dropdown-btn'>$categoria<i class='fa fa-caret-down'></i></span></a>
                            ";
                        }                             
                
    
                        if($subcategoria){
                            echo "
                            <div class='dropdown-container'>
                            ";
                            foreach ($subcategoria as $item) {
                    
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
            </div>
        </div> 
        <a href="../../controllers/usuario.controller.php?operacion=destroy" class="nav_link"> <span class="nav_name">SignOut</span></a>
    </nav>
    <!--Container Main start-->
  </div>
</div>


