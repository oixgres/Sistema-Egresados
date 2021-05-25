<?php
require_once "dbh.php";
/*	
 * Recibe:
 *	idUsuario : INT
 *
 * Devuelve:
 *	Todas las habilidades del usuario
 *
 *	(JSON)
 *	Nombre : VARCHAR(45)
 *
 *	Codigos de error:
 *  -1 : Alguno de los datos no se envio correctamente
 *	-2 : El usuario no tiene habilidades registradas
 *
*/

if(isset($_POST['idUsuario'])) {
	$idUsuario = $_POST['idUsuario'];
} else {
	echo -1;
  	$conn->close();
  	exit();
}

//Se obtiene las habilidades del usuario...

$sql = "SELECT Nombre FROM habilidades_usuario
		WHERE Usuario_idUsuario = ${idUsuario}
		ORDER BY idHabilidades_Usuario";
$res = mysqli_query($conn,$sql);

if($res->num_rows == 0) {
  	echo -2;
  	$conn->close();
  	exit();
}

//Se hace el JSON...

$json = array();

while($fila = mysqli_fetch_array($res)) {
  $json [] = $fila;
}

//Se devuelve el JSON

$jsonString = json_encode($json); 	//convertir el json a cadena
echo $jsonString; 					//retornar el json al frontend

$conn->close();
?>