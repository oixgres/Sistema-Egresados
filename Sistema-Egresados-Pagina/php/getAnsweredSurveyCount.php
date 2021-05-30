<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idEncuesta    : INT
 *
 * Devuelve numero de usuarios:
 *
 *  (JSON)
 *   total      : asignados a la encuesta
 *	 contestado : que ya contestaron la encuesta
 *   pendiente  : que faltan de contestar la encuesta
 *
 *  Códigos de error:
 *  -1 : No se mandó el idEncuesta
 *  -2 : No existe el idEncuesta en la base de datos
 *  -3 : Error en consulta
*/

if(isset($_POST['idEncuesta'])) {
    $idEncuesta = $_POST['idEncuesta'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idEncuesta FROM Encuesta WHERE idEncuesta = ${idEncuesta}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$sql = "SELECT COUNT(Encuestas_Contestadas.Usuario_idUsuario) AS contestado, COUNT(Encuestas_Pendientes.Usuario_idUsuario) AS pendiente
        FROM Encuesta
        INNER JOIN Encuestas_Contestadas ON Encuesta.idEncuesta = Encuestas_Contestadas.Encuesta_idEncuesta
        INNER JOIN Encuestas_Pendientes  ON Encuesta.idEncuesta = Encuestas_Pendientes.Encuesta_idEncuesta
        WHERE Encuesta.idEncuesta = ${idEncuesta}";

$res = mysqli_query($conn, $sql);
$json = array();

if(gettype($res) != "boolean") {
    while ($fila = mysqli_fetch_array($res)) {
        $json [] = array(
            'total' => $fila['contestado'] + $fila['pendiente'],
            'contestado' => $fila['contestado'],
            'pendiente' => $fila['pendiente']
        );
    }
}

/*
 *	JSON Ejemplo:
 *	   string(46) "[{"total":2,"contestado":"1","pendiente":"1"}]"
*/

if(!empty($json)) {
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 			    //retornar el json al frontend
} else {
    echo -3;
}
$conn->close();