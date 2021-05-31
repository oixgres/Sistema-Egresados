<?php 
require_once 'generalFunctions.php';

checkSession("user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>Editar Historial Laboral</title>

    <?php
    
    require_once 'dbh.php';
    require_once 'deleteHistory.php';


    $query = "SELECT * FROM Historial_Laboral WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    $historial_laboral = mysqli_query($conn, $query);

    $query = "SELECT * FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    $datos_laborales = mysqli_query($conn, $query);
    $datos_laborales = mysqli_fetch_assoc($datos_laborales);
    ?>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/generalcss.css">
    <link rel="stylesheet" href="../../css/profile.css">
</head>
<body>
  <!-- navbar -->
  <nav class="navbar navbar-collapse navbar-dark bg-dark modified-navbar">
    <a class="navbar-brand" href="profile.php">Sistema Egresados</a>

    <div class="row ml-auto justify-content-end">
      <a class="nav-link modified-navbar-elements" href="profile.php">Perfil </a>
      <a class="nav-link modified-navbar-elements" href="#">Acerca de</a>
      <a href="logout.php" class="nav-link modified-navbar-quit">Salir</a>
    </div>
  </nav>


    <div class="container-fluid">
      <form action="editWorkingData.php" method="post">

        <!-- Datos Laborales -->
        <div class="mt-5 row">
          <div class="col-12">
            <head>Empleo Actual</head>
            <table class="table table-bordered table-hover table-responsive-sm table-responsive-md table-responsive-lg" id="UsersContainer">
              <thead class="thead-default">
                <th>Empleo</th>
                <th>Empresa</th>
                <th>Puesto</th>
                <th>Categoria</th>
                <th>Departamento</th>
                <th>Tecnologias</th>
                <th>Actividades</th>
                <th>Accion</th>
              </thead>
              <?php if($datos_laborales['Labora'] != 0):?>
              <tr>
                <td> <?php echo $datos_laborales['Empleo']; ?> </td>
                <td> <?php echo $datos_laborales['Empresa']; ?> </td>
                <td> <?php echo $datos_laborales['Puesto']; ?> </td>
                <td> <?php echo $datos_laborales['Categoria']; ?> </td>
                <td> <?php echo $datos_laborales['Departamento']; ?> </td>
                <td> <?php echo $datos_laborales['Tecnologias']; ?> </td>
                <td> <?php echo $datos_laborales['Actividades']; ?> </td>
                  
                <td style="min-width: 115px; max-width: 120px;">
                  <button
                    name="edit"
                    value="<?php echo $datos_laborales['idDatos_Laborales']; ?>"
                    type="submit"
                    class="btn btn-primary mb-2"
                    style="width: 80px;"
                  >Editar</button>
                  
                  <a
                    href="workingHistory.php?deleteWork=<?php echo $datos_laborales['idDatos_Laborales']; ?>"
                    class="btn btn-danger mb-2"
                    style="width: 80px;"
                  >Eliminar</a>
                </td>
              </tr>
              <?php else: ?>
              <tr>
                <td> No trabaja </td>
                <td> No trabaja </td>
                <td> No trabaja </td>
                <td> No trabaja </td>
                <td> No trabaja </td>
                <td> No trabaja </td>
                <td> No trabaja </td>
                  
                <td>
                  <button
                    name="change"
                    value="<?php echo $datos_laborales['idDatos_Laborales']; ?>"
                    type="submit"
                    class="btn btn-primary mb-2"
                    style="width: 80px;"
                  >Agregar</button>
                </td>
              </tr>
              <?php endif; ?>
            </table>
          </div>
        </div>
            
        <!-- Historial Laboral -->
        <div class="mt-5 row">
          <div class="col-12">
            <head>Historial Laboral<head>
            <table class="table table-bordered table-hover table-responsive-sm table-responsive-md table-responsive-lg" id="UsersContainer">
              <thead class="thead-default">
                <th>Empleo</th>
                <th>Empresa</th>
                <th>Puesto</th>
                <th>Categoria</th>
                <th>Departamento</th>
                <th>Tecnologias</th>
                <th>Actividades</th>
                <th>Accion</th>
              </thead>
              <?php while ($row=mysqli_fetch_assoc($historial_laboral)):?>
                <?php if($row['Datos_Laborales_idDatos_Laborales'] == null): ?>
                <tr>
                  <td> <?php echo $row['Empleo']; ?> </td>
                  <td> <?php echo $row['Empresa']; ?> </td>
                  <td> <?php echo $row['Puesto']; ?> </td>
                  <td> <?php echo $row['Categoria']; ?> </td>
                  <td> <?php echo $row['Departamento']; ?> </td>
                  <td> <?php echo $row['Tecnologias']; ?> </td>
                  <td> <?php echo $row['Actividades']; ?> </td>
                    
                  <td style="min-width: 115px; max-width: 120px;">
                    <button
                      name="editHistory"
                      value="<?php echo $row['idHistorial_Laboral']; ?>"
                      type="submit"
                      class="btn btn-primary mb-2"
                      style="width: 80px;"
                    >Editar</button>
                    
                    <a
                      href="workingHistory.php?deleteHistory=<?php echo $row['idHistorial_Laboral']; ?>"
                      class="btn btn-danger mb-2"
                      style="width: 80px;"
                    >Eliminar</a>
                  </td>
                </tr>
                <?php endif; ?>
              <?php endwhile; ?>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button name="addHistory" type="submit" class="btn btn-success">Añadir Historial</button>
        </div>  
      </form>
    </div>
                
    <script src="../../js/boostrap/jquery-3.6.0.min.js"></script>
    <script src="../../js/checkSession.js"></script>
    <script src="../../js/boostrap/popper.min.js"></script>
    <script src="../../js/boostrap/bootstrap.bundle.js"></script>
    <script src="../../js/boostrap/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/5d2293cbbc.js" crossorigin="anonymous"></script>
</body>
</html>