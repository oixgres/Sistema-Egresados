<?php
require_once 'generalFunctions.php';

checkSession();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_COOKIE["name"]."".$_COOKIE["lastname"] ?></title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">

    <link rel="stylesheet" href="../css/profile.css">
  </head>
  <body class="profile-body">

    <nav class="navbar navbar-collapse navbar-dark bg-dark">
      <div class="container-fluid">

      </div>
      <a class="navbar-brand" href="profile.php">Sistema Egresados</a>

      <ul class="navbar ml-auto justify-content-end">
        <li class="nav-item active">
          <a class="nav-link" href="#">Perfil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Acerca de</a>
        </li>
      </ul>
      <a href="logout.php" class="btn btn-outline-success">Salir</a>
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
                            Desarrollador y Diseñador Web
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
                          <div class="row">
                                <div class="col-md-4">
                                    <label>Nombre:</label>
                                </div>
                                <div class="col-md-8">
                                    <p><?php echo $_COOKIE["name"]." ".$_COOKIE["lastname"] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Correo:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>kshitighelani@gmail.com</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Telefono:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>123 456 7890</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Empleo:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>Web Developer and Designer</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Empresa:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>Que te valga verga prro</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Puesto:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>Quete</p>
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
                                    <p></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p>EncuestaPrueba1</p>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-primary btn-sm">Contestar</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p>EncuestaPrueba2</p>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-primary btn-sm">Contestar</a>
                                </div>
                            </div>

                            <!-- Encuestas  Contestadas -->
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label>Encuestas Contestadas</label>
                                </div>
                                <div class="col-md-4">
                                    <p></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p>EncuestaPrueba1</p>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-secondary btn-sm">Modificar</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p>EncuestaPrueba2</p>
                                </div>
                                <div class="col-md-4">
                                  <a href="#" class="btn btn-secondary btn-sm">Modificar</a>
                                </div>
                            </div>
                        </div>

                        <!-- Historial Laboral -->
                        <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                          <div class="row">
                            <div class="col-md-8">
                              <label>21/04/2021 - Actualidad</label>
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
                                  <p>Diseñador UI/UX</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Empresa:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>Samsung</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Puesto:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>Gerente</p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Departamento:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>Diseño y Gestion de Aplicaciones</p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Actividades:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>Medir KPIs / metricas, propuestas de optimizacion de sistemas y creacion de propuestas de diseño</p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Herramientas:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>Personas, Journey Mapping y Card Sorting</p>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <label>Correo Laboral:</label>
                              </div>
                              <div class="col-md-8">
                                  <p>trabajo_empresa@hotmail.com</p>
                              </div>
                          </div>
                        </div>
                        <script src="../js/showHide.js" charset="utf-8"></script>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </body>
</html>
