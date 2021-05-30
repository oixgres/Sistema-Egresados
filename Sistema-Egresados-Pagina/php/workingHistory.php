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

    $query = "SELECT * FROM Historial_Laboral WHERE idUsuario='".$_COOKIE['id']."'";
    $historial_laboral = mysqli_query($conn, $query);
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
        <div class="mt-5 row">
            <div class="col-12">
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

                    <tbody>
                      <?php while ($row=mysqli_fetch_assoc($historial_laboral)):?>
                        <td> <?php echo $row['Empleo'] ?> </td>
                        <td> <?php echo $row['Empresa'] ?> </td>
                        <td> <?php echo $row['Puesto'] ?> </td>
                        <td> <?php echo $row['Categoria'] ?> </td>
                        <td> <?php echo $row['Departamento'] ?> </td>
                        <td> <?php echo $row['Tecnologias'] ?> </td>
                        <td> <?php echo $row['Actividades'] ?> </td>
                        
                        <td>
                          <button
                            type="button"
                            class="btn btn-success"
                          >Editar</button>
                        </td>
                      
                      <?php endwhile; ?>
                    </tbody>
                </table>
                


            </div>
        </div>
        <div class="row">
            <div class="d-flex align-items-end">
                <button class="btn btn-success form-control" id="generateCSV">Añadir Historial</button>
            </div>
        </div>

    </div>

    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-warning-">No podrá recuperar el usuario</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" value="" id="ConfirmDeleteUser">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../../js/boostrap/jquery-3.6.0.min.js"></script>
    <script src="../../js/checkSession.js"></script>
    <script src="../../js/boostrap/popper.min.js"></script>
    <script src="../../js/boostrap/bootstrap.bundle.js"></script>
    <script src="../../js/boostrap/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/5d2293cbbc.js" crossorigin="anonymous"></script>
</body>
</html>