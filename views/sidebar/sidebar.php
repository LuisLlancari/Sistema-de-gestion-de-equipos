<?php

session_start();
if(!isset($_SESSION["status"]) || !$_SESSION["status"]){
    header("Location:../../index.php");

}
$iconos = [
    "Gráficos" => "fa-chart-pie",
    "Revisiones" => "fa-screwdriver-wrench",
    "Equipos" => "fa-desktop",
    "Usuarios" => "fa-users-gear",
    "Sectores" => "fa-building"
];

$accesos = [
    "ADMINISTRADOR" =>[
        "Sectores"      => ["Inicio"],
        "Equipos"       => ["Catálogo","Panel"],
        "Revisiones"    => ["Cronograma", "Mantenimiento"],
        "Gráficos"      => ["Estadísticas"],
        "Usuarios"       => ["Usuario"]
    ],
    "ASISTENTE" =>[
        "Sectores"      => ["Inicio"],
        "Equipos"       => ["Catálogo"],
        "Revisiones"    => ["Cronograma", "Mantenimiento"]
    ]
];

    function reemplazarCadena($string)
    {
        $tildes = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'G'];
        $reemplazos = ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'g'];
        return str_replace($tildes,$reemplazos,$string);
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>SISCOMPU</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- <link href="/website/css/uicons-outline-rounded.css"rel="stylesheet"> -->

    <!-- Font Awesome icons (free version)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BOOTSTRAP - ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/modal.css">
</head>

<body id="body-pd">
  <main>
    <div class="sidenav">
    <a href='#' class='nav_link cat'>
        <span style='font-size: larger;'><strong>SISCOMPU</strong></span>
    </a>
        <header class="header"id="header">
            <div class="centered-span">
                <span class="text-uppercase"><?=$_SESSION["apellidos"]?><span>, <span class="center-span"><?=$_SESSION["nombres"]?> - </span> <span id="rolObt"><?=$_SESSION["rol"]?></span> 
            </div>
            <div class="header_img centered-img"> 
                <?php
                    echo "<img src='../../images/".$_SESSION["avatar"]."' alt=''>";  
                ?> 
            </div>
        </header>

        <div class="l-navbar" id="sidebar">
            <nav class="nav">
                <div>
                    <div class="nav_list" id="navlist"> 
                    <?php
                        $categorias = $accesos[$_SESSION["rol"]];
                        foreach ($categorias as $categoria => $subcategoria) {
                            $icono = $iconos[$categoria];
                            $cadena = reemplazarCadena(strtolower($categoria));

                            if ($categoria == "Equipos" || $categoria == "Revisiones") {
                                echo "<a type='button' href='#' class='dropdown-btn'><i class='fas {$icono}'></i> $categoria<i class='fa fa-caret-down'></i></span></a>";
                                if ($subcategoria) {
                                    echo "<div class='dropdown-container'>";
                                    foreach ($subcategoria as $item) {
                                        $cadenaSub = reemplazarCadena(strtolower($item));
                                        echo "<li><a href='../{$cadena}/{$cadenaSub}.php' class='nav_link'><span class='nav_name'>$item</span></a></li>";
                                    }
                                    echo "</div>";
                                }
                            } else {
                                echo "<a href='../{$cadena}/{$cadena}.php' class='nav_link cat'><i class='fas {$icono}'></i> $categoria</a>";
                            }

                            echo "</li>";
                        }
                    ?>
            </div>
        </div>
        <div class="mt-4">
            <a href="../../controllers/usuario.controller.php?operacion=destroy" class="nav_link"> <span class="nav_name"> 
                <strong> <i class="bi bi-box-arrow-left"></i> Cerrar sesión </strong></span></a>
        </div> 
    </nav>
    <!--Container Main start-->
  </div>
</div>


