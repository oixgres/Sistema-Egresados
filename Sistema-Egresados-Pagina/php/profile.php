<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_COOKIE["name"]."".$_COOKIE["lastname"] ?></title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
  </head>
  <body>
    <nav class="navbar navbar-collapse navbar-dark bg-dark">
      <div class="container-fluid">

      </div>
      <a class="navbar-brand" href="profile.php">Sistema Egresados</a>

      <ul class="navbar ml-auto justify-content-end">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
      </ul>
      <a href="#" class="btn btn-outline-success">Salir</a>
    </nav>
    <?php if($_COOKIE["token"] == $_SESSION["token"]): ?>
      <p><?php echo "Bienvenido ".$_COOKIE["name"]; ?></p>
    <?php else: ?>
      <p><?php echo "Ocurrio un error"; ?></p>
    <?php endif; ?>

  </body>
</html>
