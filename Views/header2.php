<?php
session_start();

$permisos = [
    "ADMIN" => ["index","usuarios","categorias","productos","roles","ventas","reportes"],
    "ASIST" => ["index","categorias","productos","ventas","reportes"],
    "INV"   => ["index","productos"]
];

if(!isset($_SESSION["status"]) || $_SESSION["status"] == false){
    header("Location:../../login.php");
    exit();
}
?>

<!doctype html>
<html lang="es">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="../index.php">APPSTORE</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <a class="nav-item">
                        <!-- <a href="../categoria/categoria.php" class="nav-link">Lista de categorias</a>
                        <a href="../producto/listar.php"class="nav-link">Lista de productos</a>
                        <a href="../producto/registrar.php" class="nav-link">Registro de productos</a>
                        <a href="../usuario/listar.php" class="nav-link">Lista de usuarios</a>
                        <a href="../usuario/registrar.php" class="nav-link">Registro de usuarios</a>
                    -->

                    <?php
                    $listaOpciones = $permisos[$_SESSION["rol"]];

                    foreach($listaOpciones as $opcion){
                        if($opcion != "index"){
                            echo "
                            <li>
                                <a href='../{$opcion}/listar.php'class='nav-link'>{$opcion}-Lista</a>
                                <a href='../{$opcion}/registrar.php'class='nav-link'>{$opcion}-Registro</a>
                            </li>
                        ";
                        }
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION["apellidos"]?>
                            <?= $_SESSION["nombres"]?>
                            (<?= $_SESSION["rol"]?>)
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="../../controllers/usuario.controller.php?operacion=destroy">Cerrar sesión</a>
                            <a class="dropdown-item" href="#">Cambiar contraseña</a>
                        </div>
                    </li>
                </ul>
            </div>
      </div>
    </nav>

    <?php
    $url = $_SERVER['REQUEST_URI'];

    $arregloURL = explode("/",$url);

    $vistaActual = $arregloURL[count($arregloURL)-2];

    $permitido = false;

    
    foreach ($listaOpciones as $opcion) {

       
        if($opcion == $vistaActual){

            $permitido = true;

            
        }
    }


    if(!$permitido){
        echo "
        <div class='container mt-3'>
            <h3>acceso DENEGADO</h3>
            <hr>
            <p>
            Ud. no cuenta con los permisos suficientes para acceder a este apartado
            </p>
        </div>
        ";
        exit();
    }
    ?>