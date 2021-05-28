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

    $query = "SELECT * FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    $datos_laborales = mysqli_query($conn, $query);
    $datos_laborales = mysqli_fetch_assoc($datos_laborales);
    ?>

    <title>Registro de datos</title>

    <link rel="stylesheet" href="../css/boostrap/bootstrap_pulse.min.css"> <!-- Nuevos estilos de boostrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
  </head>
  <body>
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
                            <div class="card-body">
                              <div class="mt-3" id="questionContainerForIsWorking">
                                <div class="row">
                                    <div class="col-6">
                                        <label>
                                            Fecha en que inició a trabajar
                                            <input
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
                                                type="text"
                                                placeholder="actividades que realiza"
                                                class="form-control"
                                                id="Actividades"
                                              ><?php echo $datos_laborales['Actividades']; ?></textarea>
                                          </label>
                                      </div>
                                  </div>

                              </>

                              <div class="row mt-3">
                                  <div class="col-12 d-flex justify-content-center">
                                      <button type="button" class="btn btn-success" id="sendWorkingDataBtn">
                                          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                          Guardar
                                      </button>
                                  </div>
                              </div>

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
</body>
</html>