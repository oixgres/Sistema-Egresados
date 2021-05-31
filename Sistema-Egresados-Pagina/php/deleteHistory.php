<?php 

if(isset($_GET['deleteHistory']))
{ 
  $query ="DELETE FROM Historial_Laboral WHERE idHistorial_Laboral='".$_GET['deleteHistory']."'";
  mysqli_query($conn, $query);
}
else
  if(isset($_GET['deleteWork'])){
    $query="DELETE FROM Datos_Laborales WHERE Usuario_idUsuario='".$_COOKIE['id']."'";
    mysqli_query($conn, $query);

    $query = "INSERT INTO Datos_Laborales (Usuario_idUsuario, Labora, Empleo, Empresa, Puesto, Categoria, Correo_Emp, Departamento, Tecnologias, Actividades, Inicio) VALUES ('".$_COOKIE['id']."', 0, null, null, null, null, null, null, null, null, null)";
    mysqli_query($conn, $query);
  }
?>