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

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <a class="nav-item">
                        <a href="../../categoria/categoria.php" class="nav-link">Lista de categorias</a>
                        <a href="../../producto/listar.php"class="nav-link">Lista de productos</a>
                        <a href="../../producto/registrar.php" class="nav-link">Registro de productos</a>
                        <a href="../../usuario/listar.php" class="nav-link">Lista de usuarios</a>
                        <a href="../../usuario/registrar.php" class="nav-link">Registro de usuarios</a>
                        <a href="/.php" class="nav-link"></a>
                   
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="../controllers/usuario.controller.php?operacion=destroy">Cerrar sesión</a>
                            <a class="dropdown-item" href="#">Cambiar contraseña</a>
                        </div>
                    </li>
                </ul>
            </div>
      </div>
    </nav>