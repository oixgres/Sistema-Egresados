<?php
require_once 'generalFunctions.php';

checkSession("user");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
    require_once 'dbh.php';
    ?>

    <title>Registro de datos</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/generalcss.css">
    <link rel="stylesheet" href="../css/profile.css">
    
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-collapse navbar-dark bg-dark modified-navbar">
      <a class="navbar-brand" href="profile.php">Sistema Egresados</a>

      <div class="row ml-auto justify-content-end">
        <a class="nav-link modified-navbar-elements" href="profile.php">Perfil </a>
        <a class="nav-link modified-navbar-elements" href="#">Acerca de</a>
        <a href="logout.php" class="nav-link modified-navbar-quit">Salir</a>
      </div>
    </nav>

    <div class="mt-5 container-fluid">
      <div class="row">
        <div class="col-12">
          <div id="datosLaborales" class="content" role="tabpanel">
            <div class="row h-100 align-content-center">
              <div class="col-12 col-lg-8 col-xl-6 offset-lg-2 offset-xl-3">
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center">Editar Datos Laborales</h2>
                  </div>

                  <?php

                  $action = '';

                  if(isset($_POST['edit']))
                  {
                    $query = "SELECT * FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
                    $datos_laborales = mysqli_query($conn, $query);
                    $datos_laborales = mysqli_fetch_assoc($datos_laborales);

                    $action = 'edit';
                  }
                  else
                    if(isset($_POST['change']))
                    {
                      $action = 'change';
                    }
                  

                  ?>
                  <div class="card-body">
                    <div class="mt-3" id="questionContainerForIsWorking">
                      
                      <form action="editWorkingDataDB.php" method="POST">
                        <input type="hidden" name="action" value=<?php echo $action; ?>>

                        <div class="row">
                          <div class="col-6">
                            <label>
                              Fecha en que inició a trabajar
                              <input
                              name="fecha"
                              type="date"
                              class="form-control"
                              id="initWorkDate"
                              value="<?php echo $datos_laborales['Inicio']; ?>"
                              >
                            </label>
                          </div>
                        </div>  

                        <div class="row">
                          <div class="col-6">
                            <label class="w-100">
                              Empleo:
                              <input
                                name="empleo"
                                type="text"
                                placeholder="Empleo Actual"
                                class="form-control"
                                id="Empleo"
                                value="<?php echo $datos_laborales['Empleo']; ?>"
                              >
                            </label>
                          </div>

                          <div class="col-6">
                            <label class="w-100">
                              Empresa:
                              <input
                                name="empresa"
                                type="text"
                                placeholder="Empresa Actual"
                                class="form-control"
                                id="Empresa"
                                value="<?php echo $datos_laborales['Empresa']; ?>"
                              >
                            </label>
                          </div>
                        </div>
                        
                        <div class="row mt-3">
                          <div class="col-6">
                            <label class="w-100">
                              Puesto:
                              <input
                                name="puesto"
                                type="text"
                                placeholder="Puesto Actual"
                                class="form-control"
                                id="Puesto"
                                value="<?php echo $datos_laborales['Puesto']; ?>"
                              >
                            </label>
                          </div>

                          <div class="col-6">
                            <label class="w-100">
                              Categoria:
                              <input
                                name="categoria"
                                type="text"
                                placeholder="Categoria del puesto"
                                class="form-control"
                                id="Categoria"
                                value="<?php echo $datos_laborales['Categoria']; ?>"
                                >
                            </label>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col-6">
                            <label class="w-100">
                              Correo Empresarial:
                              <input
                              name="correo"
                                type="text"
                                placeholder="Correo electronico"
                                class="form-control"
                                id="CorreoEmpresa"
                                value="<?php echo $datos_laborales['Correo_Emp']; ?>"
                              >
                            </label>
                          </div>
                          

                          <div class="col-6">
                            <label class="w-100">
                              Departamento:
                              <input
                              name="departamento"
                                type="text"
                                placeholder="Departamento"
                                class="form-control"
                                id="Departamento"
                                value="<?php echo $datos_laborales['Departamento']; ?>"  
                                >
                            </label>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col-12">
                            <label class="w-100">
                              Tecnologias:
                              <textarea
                                name="tecnologias"
                                type="text"
                                placeholder="Tecnologias usadas"
                                class="form-control"
                                id="Tecnologias"
                              ><?php echo $datos_laborales['Tecnologias']; ?></textarea>
                            </label>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col-12">
                            <label class="w-100">
                              Actividades:
                              <textarea
                              name="actividades"
                                type="text"
                                placeholder="actividades que realiza"
                                class="form-control"
                                id="Actividades"
                              ><?php echo $datos_laborales['Actividades']; ?></textarea>
                            </label>
                          </div>
                        </div>
                        
                        <div class="row mt-3">
                          <div class="col-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">
                              <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                              Guardar
                            </button>
                          </div>
                        </div>                      
                      </form>
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script src="../js/boostrap/jquery-3.6.0.min.js"></script>
      <script src="../js/boostrap/popper.min.js"></script>
      <script src="../js/boostrap/bootstrap.bundle.js"></script>
      <script src="../js/boostrap/bootstrap.js"></script>

      <script src="../js/editWorkData.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    </div>
  </body>
</html>