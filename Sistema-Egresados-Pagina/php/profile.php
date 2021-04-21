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
                            Web Developer and Designer
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
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>WORK LINK</p>
                        <a href="">Website Link</a><br/>
                        <a href="">Bootsnipp Profile</a><br/>
                        <a href="">Bootply Profile</a>
                        <p>SKILLS</p>
                        <a href="">Web Designer</a><br/>
                        <a href="">Web Developer</a><br/>
                        <a href="">WordPress</a><br/>
                        <a href="">WooCommerce</a><br/>
                        <a href="">PHP, .Net</a><br/>
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
                                    <label>Empresa:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>Que te valga verga prro</p>
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
                                    <label>Rol:</label>
                                </div>
                                <div class="col-md-8">
                                    <p>Quete</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="survey" role="tabpanel" aria-labelledby="survey-tab">
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>Experience</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>Expert</p>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>Hourly Rate</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>10$/hr</p>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>Total Projects</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>230</p>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>English Level</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>Expert</p>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>Availability</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>6 months</p>
                                  </div>
                              </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Your Bio</label><br/>
                                    <p>Your detail description</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>La vaca lola</label>
                                  </div>
                                  <div class="col-md-8">
                                      <p>Tiene cabeza y tiene cola</p>
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
