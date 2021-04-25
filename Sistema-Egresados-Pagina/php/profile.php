<?php
require_once 'generalFunctions.php';

checkSession();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_COOKIE["name"]." ".$_COOKIE["lastname"] ?></title>

    <?php
    /* Consultas */
    require_once "dbh.php";

    $datos_personales = mysqli_query($conn, "SELECT * FROM Datos_Personales WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");
    $datos_laborales = mysqli_query($conn, "SELECT * FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");

    /* Obtenemos el historial laboral*/
    $historial_laboral = mysqli_query($conn, "SELECT * FROM Historial_Laboral WHERE Usuario_idUsuario='".$_COOKIE["id"]."' ORDER BY Inicio DESC");

    /* Encuestas contestadas */
    $unansweredSurveys = mysqli_query($conn, "SELECT * FROM Encuestas_Pendientes WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");
    $answeredSurveys = mysqli_query($conn, "SELECT * FROM Encuestas_Contestadas WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");

    $datos_personales = mysqli_fetch_assoc($datos_personales);
    $datos_laborales = mysqli_fetch_assoc($datos_laborales);

    /* Obtenemos ciudad y estado */
    $city = getFirstQueryElement($conn, "Ciudad", "Nombre", "idCiudad", $datos_personales["Ciudad_idCiudad"]);
    $state = getFirstQueryElement($conn, "Estado", "Nombre", "idEstado", $datos_personales["Estado_idEstado"]);



    ?>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/generalcss.css">
    <link rel="stylesheet" href="../css/profile.css">
  </head>
  <body class="profile-body">

    <!-- navbar -->
    <nav class="navbar navbar-collapse navbar-dark bg-dark modified-navbar">
      <a class="navbar-brand" href="profile.php">Sistema Egresados</a>

      <div class="row ml-auto justify-content-end">
        <a class="nav-link modified-navbar-elements" href="#">Perfil </a>
        <a class="nav-link modified-navbar-elements" href="#">Acerca de</a>
        <a href="logout.php" class="nav-link modified-navbar-quit">Salir</a>
      </div>
    </nav>

    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
                        <div class="file btn btn-lg btn-primary">
                            Cambiar Foto
                            <input type="file" name="file"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            <?php echo $_COOKIE["name"]." ".$_COOKIE["lastname"] ?>
                        </h5>
                        <h6>
                            <?php echo $datos_laborales["Empleo"]; ?>
                        </h6>
                        <ul class="mt-5 nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="survey-tab" data-toggle="tab" href="#survey" role="tab" aria-controls="survey" aria-selected="true">Encuestas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Historial</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Editar"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>LINKS</p>
                        <a href="">Github</a><br/>
                        <a href="">Empresa Osi Osi</a><br/>
                        <a href="">Linkedin</a>
                        <p>HABILIDADES</p>
                        <a href="">Diseño Web</a><br/>
                        <a href="">Desarrollo Web</a><br/>
                        <a href="">Sistemas Embebidos</a><br/>
                        <a href="">Aplicaciones Moviles</a><br/>
                        <a href="">Experto en Miches</a><br/>
                    </div>
                </div>
                <!-- Acerca de -->
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <!-- Nombre -->
                          <div class="row">
                                <div class="col-md-4">
                                    <label>Nombre:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $_COOKIE["name"]." ".$_COOKIE["lastname"] ?></p>
                                </div>
                            </div>

                            <!-- Correo -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Correo Personal:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $_COOKIE["mail"]; ?></p>
                                </div>
                            </div>

                            <!-- Telefono -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Telefono:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $datos_personales["Telefono"]; ?></p>
                                </div>
                            </div>

                            <!-- Ubicacion -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Ubicacion:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $state.", ".$city; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Empleo:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $datos_laborales["Empleo"]; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Empresa:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $datos_laborales["Empresa"]; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Puesto:</label>
                                </div>
                                <div class="col-md-8">
                                    <p> <?php echo $datos_laborales["Puesto"]; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Departamento:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $datos_laborales["Departamento"]; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Encuestas Pendientes-->
                        <div class="tab-pane fade show active" id="survey" role="tabpanel" aria-labelledby="survey-tab">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Encuestas Pendientes</label>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-primary modified-small-button">Ver</a>
                                </div>
                            </div>

                            <?php while ($row = mysqli_fetch_assoc($unansweredSurveys)): ?>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p><?php $row["Nombre"]; ?></p>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                            <?php endwhile; ?>

                            <!-- Encuestas  Contestadas -->
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label>Encuestas Contestadas</label>
                                </div>
                                <div class="col-md-4">
                                    <p></p>
                                </div>
                            </div>

                            <?php while($row = mysqli_fetch_assoc($answeredSurveys)): ?>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p><?php $row["Nombre"]; ?></p>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-secondary modified-small-button">Modificar</a>
                                </div>
                            </div>
                          <?php endwhile; ?>
                        </div>

                        <!-- Historial Laboral -->
                        <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                          <?php while($row = mysqli_fetch_assoc($historial_laboral)): ?>
                          <div class="row">
                            <div class="col-md-8">
                              <?php if(!isset($row["Fin"])): ?>
                              <label><?php echo date("d/m/Y",strtotime($row["Inicio"]))." - Actualidad"; ?></label>
                              <?php else: ?>
                              <label><?php echo date("d/m/Y",strtotime($row["Inicio"]))." - ".date("d/m/Y",strtotime($row["Fin"])); ?></label>
                              <?php endif; ?>

                            </div>
                            <div class="col-md-4">
                              <p></p>
                            </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Empleo:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Empleo"]; ?></p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Empresa:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Empresa"]; ?></p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Puesto:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Puesto"]; ?></p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Departamento:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Departamento"]; ?></p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Actividades:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Actividades"]; ?></p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Tecnologias:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Tecnologias"]; ?></p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Correo Laboral:</label>
                              </div>
                              <div class="col-md-8">
                                  <p><?php echo $row["Correo_Emp"]; ?></p>
                              </div>
                          </div>
                        <?php endwhile; ?>
                        </div>
                        <script src="../js/showHide.js" charset="utf-8"></script>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </body>
</html>
