<?php
require_once "dbh.php";
/*	
 * Recibe:
 *	idUsuario : INT
 *
 * Devuelve:
 *	Todas los links que el usuario ha registrado.
 *
 *	(JSON)
 *	Nombre : VARCHAR(45)
 *	Link : VARCHAR(200)
 *
 *	Codigos de error:
 *  -1 : Alguno de los datos no se envio correctamente
 *	-2 : El usuario no tiene links registrados
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

$sql = "SELECT Nombre, Link FROM enlaces_usuario
		WHERE Usuario_idUsuario = ${idUsuario}
		ORDER BY idEnlaces_Usuario";
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
echo $jsonString; 	

$conn->close();
?>