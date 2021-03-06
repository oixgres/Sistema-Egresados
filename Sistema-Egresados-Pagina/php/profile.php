<?php
require_once 'generalFunctions.php';

checkSession("user");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_COOKIE["name"]." ".$_COOKIE["lastname"] ?></title>

    <?php
    /* Consultas */
    require_once "dbh.php";

    $usuario = mysqli_query($conn, "SELECT * FROM Usuario WHERE idUsuario='".$_COOKIE['id']."'");
    $usuario = mysqli_fetch_assoc($usuario);

    $datos_personales = mysqli_query($conn, "SELECT * FROM Datos_Personales WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");
    $datos_laborales = mysqli_query($conn, "SELECT * FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");

    /* Obtenemos la foto de perfil */
    $profilePicture = mysqli_query($conn, "SELECT * FROM Foto_Perfil WHERE Usuario_idUsuario='".$_COOKIE['id']."'");

    /* Obtenemos enlaces y habilidades */
    $links = mysqli_query($conn, "SELECT * FROM Enlaces_Usuario WHERE Usuario_idUsuario='".$_COOKIE['id']."'");
    $linksPopup = mysqli_query($conn, "SELECT * FROM Enlaces_Usuario WHERE Usuario_idUsuario='".$_COOKIE['id']."'");

    $skills = mysqli_query($conn, "SELECT * FROM Habilidades_Usuario WHERE Usuario_idUsuario='".$_COOKIE['id']."'");
    $skillsPopup = mysqli_query($conn, "SELECT * FROM Habilidades_Usuario WHERE Usuario_idUsuario='".$_COOKIE['id']."'");

    /* Obtenemos el historial laboral*/
    $historial_laboral = mysqli_query($conn, "SELECT * FROM Historial_Laboral WHERE Usuario_idUsuario='".$_COOKIE["id"]."' ORDER BY Inicio DESC");

    /* Encuestas contestadas */
    $unansweredSurveys = mysqli_query($conn, "SELECT * FROM Encuestas_Pendientes WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");
    $answeredSurveys = mysqli_query($conn, "SELECT * FROM Encuestas_Contestadas WHERE Usuario_idUsuario='".$_COOKIE["id"]."'");


    $datos_personales = mysqli_fetch_assoc($datos_personales);
    $datos_laborales = mysqli_fetch_assoc($datos_laborales);
    $profilePicture = mysqli_fetch_assoc($profilePicture);

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
        <a class="nav-link modified-navbar-elements" href="profile.php">Perfil </a>
        <a class="nav-link modified-navbar-elements" href="#">Acerca de</a>
        <a href="logout.php" class="nav-link modified-navbar-quit">Salir</a>
      </div>
    </nav>

    <div class="container emp-profile">
        <form id="profile-picture" method="post" action="uploadPicture.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="<?php echo $profilePicture['Direccion'] ?>"/>
                        <div class="file btn btn-lg btn-primary">
                            Cambiar Foto
                            <input type="file" name="file" id="file_profile"/>
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
                    <input type="button" class="profile-edit-btn cursor-on" onclick="editPopup()" value="Editar"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>LINKS</p>
                        <?php while($row = mysqli_fetch_assoc($links)): ?>
                          <a 
                            name="<?php echo $row['idEnlaces_Usuario']; ?>"
                            href="<?php echo $row['Link']; ?>"
                            class="profile-link"
                          ><?php echo $row['Nombre']; ?></a>
                          <br/>
                        <?php endwhile; ?>
                        <a class="cursor-on" onclick="linkPopup()">+</a>
                        
                        <p>HABILIDADES</p>
                        <?php while ($row = mysqli_fetch_assoc($skills)): ?>
                          <a
                            href=""
                            name = "<?php echo $row['idHabilidades_Usuario']?>"
                            class="profile-skill"
                          ><?php echo $row['Nombre']; ?></a>
                          <br/>
                        <?php endwhile; ?>
                        <a class="cursor-on" onclick="skillPopup()">+</a><br/>
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
                            
                            <!-- Contrase??a -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Contrase??a</label>
                                </div>
                                <div class="col-md-8">
                                    <p class="" id="pass_hide">*************</p>
                                    <div class="input-group mb-3 d-none" id="passContainer">
                                        <input type="password" class="form-control" placeholder="Nueva contrase??a" id="newPassWord">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info" type="button" id="saveNewPassword">Aceptar</button>
                                        </div>
                                    </div>

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
                                  <a href="../html/ShowSurvey.html" class="btn btn-primary modified-small-button">Ver</a>
                                </div>
                            </div>

                            <?php while ($row = mysqli_fetch_assoc($unansweredSurveys)): ?>
                            <div class="row">
                                <div class="col-md-8 mt-1">
                                  <p><?php echo $row["Nombre"]; ?></p>
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
                                  <p><?php echo $row["Nombre"]; ?></p>
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
    <!-- Popup de los links -->
    <div class="popup" id="popup-link">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-button" onclick="linkPopup()">&times;</div>
        <h1 class="popup-title">LINKS</h1>

        <div id="all-links">
        <?php while($row = mysqli_fetch_assoc($linksPopup)): ?>
          <!-- ID del link -->
          <form class="form-links" id="<?php echo $row['idEnlaces_Usuario'] ?>">
            <div class="row mb-3">
              <div class="col-8">
                <!-- Nombre del link -->
                <input 
                  type="text"
                  class="form-control modified-middle-input ml-3 input-link-name"
                  placeholder="Nombre"
                  name="name"
                  value = "<?php echo $row['Nombre'];?>"
                  >
              </div>
              <div class="col-4">
                <button
                  type="submit"
                  value="submit"
                  name="button"
                  class="btn btn-primary modified-middle-button save-link"
                >Guardar</button>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col-8">
                <!-- Link -->
                <input
                  type="text"
                  class="form-control modified-middle-input ml-3 input-link-url"
                  placeholder="Enlace"
                  name="link"
                  value="<?php echo $row['Link']; ?>"
                >
              </div>
              <div class="col-4">
                <button
                  type="button"
                  name="button"
                  class="btn btn-danger modified-middle-button delete-links"
                >Eliminar</button>
              </div>
            </div>
          </form>
        <?php endwhile; ?>
        </div>

        <div class="d-flex justify-content-center">
          <button
            type="button"
            name="button"
            class="btn btn-primary modified-middle-button"
            onclick="newLinks()"
          >Nuevo</button>
        </div>
      </div>
    </div>

    <!-- popup de los skills -->
    <div class="popup" id="popup-skill">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-button" onclick="skillPopup()">&times;</div>
        <h1 class="popup-title">HABILIDADES</h1>

        <div id="all-skills">
        <?php while($row = mysqli_fetch_assoc($skillsPopup)):?>
          <!-- ID del skill -->
          <form class="form-skills" id="<?php echo $row['idHabilidades_Usuario']?>">
            <div class="row mb-2">
              <div class="col-8">
                <!-- Habilidad -->
                <input
                  type="text"
                  class="form-control modified-middle-input ml-3 input-skill"
                  placeholder="Habilidad"
                  name="skill"
                  value="<?php echo $row['Nombre']; ?>">
              </div>
              <!-- Boton de guardado -->
              <div class="col-4">
                <button
                  type="submit"
                  name="button"
                  class="btn btn-primary modified-middle-button"
                >Guardar</button>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-8">
              </div>
              <div class="col-4">
                <button
                  type="button"
                  name="button"
                  class="btn btn-danger modified-middle-button delete-skills"
                >Eliminar</button>
              </div>
            </div>
          </form>
        <?php endwhile; ?>
        </div>

        <div class="d-flex justify-content-center">
          <button
            type="button"
            name="button"
            class="btn btn-primary modified-middle-button"
            onclick="newSkills()"
          >Nuevo</button>
        </div>
      </div>
    </div>

    <!-- Popup de edicion -->
    <?php if($usuario['Actualizaciones'] > 0): ?>
    <div class="popup" id="popup-edit">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-button" onclick="editPopup()">&times;</div>
        <h1 class="popup-title">EDITAR</h1>
        
        <!-- Editar Perfil -->
        <form action="editWorkingData.php" method="post">

          <!-- Editar/Corregir datos laborales -->
          <div class="d-flex justify-content-center">
            <button
              type="submit"
              name="edit"
              class="profile-edit-btn btn-primary btn-lg"
              style="color:aliceblue;"
            >Editar Empleo Actual</button>
          </div>

          <!-- Cambio de empleo -->
          <div class="d-flex justify-content-center mt-4">
            <button
              type="submit"
              name="change"
              class="profile-edit-btn btn-primary btn-lg"
              style="color:aliceblue;"
            >Cambio de Empleo</button>
          </div>
          
          <!-- Eliminar/Borrar historial -->
          <div class="d-flex justify-content-center mt-4 mb-4">
            <a
              href="workingHistory.php"
              class="profile-edit-btn btn-primary btn-lg"
              style="color:aliceblue;"
            >Editar historial</a>
          </div>
          
          <!-- Borrar perfil -->
          <div class="d-flex justify-content-center mt-4 mb-4">
            <button
              type="button"
              name="button"
              class="profile-edit-btn btn-danger btn-lg"
              style="color:aliceblue;"
            >Eliminar Perfil</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Popup de edicion inhabilitada -->
    <?php else: ?>
    <div class="popup" id="popup-edit">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-button" onclick="editPopup()">&times;</div>
        <h1 class="popup-title">Numero de Actualizaciones Excedido</h1>

        <p>
          Has excedido el numero maximo de actualizaciones mensuales en su perfil.
          <br>
          Si desea continuar realizando actualizaciones comuniquese con el administrador.
        </p>  
      </div>
    </div>
    <?php endif; ?>
    <script src="../js/popup.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/profile_status.js"></script>
  </body>
</html>
