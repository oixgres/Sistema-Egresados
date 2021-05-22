<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario    : INT
 * 	estado       : INT
 *      0 - pendientes
 *      1 - contestadas
 *
 * Devuelve:
 * 	Todas las encuestas correspondientes a ese usuario en el siguiente orden:
 * 
 *  (JSON)
 *  idEncuesta : INT
 *	Nombre : VARCHAR(45)
 *  Nombre del alcance : VARCHAR(45)
 *  Alcance : INT 
 *		[0 - Universidad    ]
 *		[1 - Campus         ]
 *	  	[2 - Facultad       ]
 *    	[3 - Plan academico ]
 *     
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario o estado
 *  -2 : No existe el idUsuario en la base de datos
 *	-3 : No existen encuestas para este idUsuario
*/

if(!isset($_POST['idUsuario']) || !isset($_POST['estado'])) {
    echo -1;
    $conn->close();
    exit();
} else {
    $idUsuario = $_POST['idUsuario'];
    $estado = $_POST['estado'];
}

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = ${idUsuario}";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$estadoEncuestas = array("Pendientes", "Contestadas");
$alcances = array("Universidad", "Campus", "Facultad", "Plan_Estudio");
$json = array();

for($i = 0; $i < 4; $i++) {
    $sql = "SELECT Encuestas_${estadoEncuestas[$estado]}.Encuesta_idEncuesta AS idEncuesta, Encuestas_${estadoEncuestas[$estado]}.Nombre AS encuesta, ${alcances[$i]}.Nombre AS alcance
            FROM Encuestas_${estadoEncuestas[$estado]}
            INNER JOIN Encuesta         ON Encuestas_${estadoEncuestas[$estado]}.Encuesta_idEncuesta = Encuesta.idEncuesta
            INNER JOIN ${alcances[$i]}  ON Encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
            INNER JOIN Datos_Escolares  ON ${alcances[$i]}.id${alcances[$i]} = Datos_Escolares.${alcances[$i]}_id${alcances[$i]}
            INNER JOIN Usuario          ON Datos_Escolares.Usuario_idUsuario = Usuario.idUsuario
            WHERE  Encuestas_${estadoEncuestas[$estado]}.Usuario_idUsuario = ${idUsuario}
            GROUP BY Encuestas_${estadoEncuestas[$estado]}.Encuesta_idEncuesta";

    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean") {
        while ($fila = mysqli_fetch_array($res)) {
            $json [] = array(
                'idEncuesta' => $fila['idEncuesta'],
                'encuesta' => $fila['encuesta'],
                'alcance' => $fila['alcance'],
                'tipoAlcance' => $i
            );
        }
    }
}

/*
 *	JSON Ejemplo:
 *	   string(84) "[{"idEncuesta":"3","encuesta":"Historial laboral","alcance":"UABC","tipoAlcance":0}]"
*/

if(!empty($json)) {
    $jsonString = json_encode($json); 	//convertir el json a cadena
    echo $jsonString; 					//retornar el json al frontend
} else {
    echo -3;
}

$conn->close();