<?php
require_once "generalFunctions.php";

checkSession("admin");
 ?>
!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menu Principal</title>

    <!-- bootstrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/generalcss.css">
  </head>

  <body>
    <!-- navbar -->
    <nav class="navbar navbar-collapse navbar-dark bg-dark modified-navbar">
      <a class="navbar-brand" href="menu.php">Sistema Egresados</a>

      <div class="row ml-auto justify-content-end">
        <div class="nav-item dropdown">
          <a
            id="navDropdown"
            class="nav-link modified-navbar-elements dropdown-toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >Encuestas</a>
          <div class="dropdown-menu" aria-labelledby="navDropdown">
            <a class="dropdown-item" href="../html/SurveyCreator.html">Crear Encuesta</a>
            <a class="dropdown-item" href="#">Editar Encuestas</a>
          </div>
        </div>

        <a class="nav-link modified-navbar-elements" href="../html/userFinder.html">Buscar Usuarios</a>
        <a href="logout.php" class="nav-link modified-navbar-quit">Salir</a>
      </div>
    </nav>
    <h1 class="welcome">Bienvenido <?php $_COOKIE["name"]." ".$_COOKIE["lastname"]; ?></h1>
  </body>
</html>
