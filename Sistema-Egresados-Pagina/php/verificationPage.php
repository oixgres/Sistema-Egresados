<?php  //session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
  </head>
  <body>
    <div class="container account-created-message">
      <div class="row align-items-center">
        <div class="col align-self-center">
          <div class="alert alert-success" role="alert">
            <form class="" action="../php/verifyUser.php" method="post" align="center">

              <h4 class="alert-heading mt-3 mb-3">Activa tu cuenta!</h4>
              <p class="mb-5">Se ha enviado una clave para verificar su cuenta</p>
              <p>Ingrese su clave</p>

              <div class="row">
                <div class="col-9">
                  <input type="text" name="key" class="form-control ml-4 mb-5" placeholder="Introduzca clave de confirmacion">
                </div>
                <div class="col-3">
                  <button type="button" name="sendButton" class="btn btn-info mr-4">Enviar</button>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <a class="btn btn-outline-success" href="../index.html">Pagina Principal</a>
                </div>
                <div class="col-6">
                  <a class="btn btn-outline-success" href="#">Generar Clave</a>
                </div>
              </div>

              <!--
              <input type="hidden" name="idUser" value="<?php //$_SESSION['idUser']; ?>">
              <?php //session_destroy(); ?>
              -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
