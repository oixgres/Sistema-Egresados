<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idUsuario : INT 
 * 
 * Devuelve:
 * 	Todas las encuestas disponibles para ese usuario en el siguiente orden:
 * 
 *  (JSON)
 *  IdEncuesta : INT
 *	Nombre : VARCHAR(45)
 *  Nombre del alcance : VARCHAR(45)
 *  Alcance : INT 
 *		[0 - Universidad    ]
 *		[1 - Campus         ]
 *	  	[2 - Facultad       ]
 *    	[3 - Plan academico ]
 *     
 *  Códigos de error:
 *  -1 : No se mandó el idUsuario
 *  -2 : No existe el idUsuario en la base de datos
 *	-3 : No existen encuestas para este idUsuario
*/

if(isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$sql = "SELECT idUsuario FROM Usuario WHERE idUsuario = '$idUsuario'";
$res = mysqli_query($conn, $sql);

if($res->num_rows == 0) {
    echo -2;
    $conn->close();
    exit();
}

$alcances = array("Universidad", "Campus", "Facultad", "Plan_Estudio");
$json = array();

for($i = 0; $i < 4; $i++) {
    $sql = "SELECT idEncuesta, Encuesta.Nombre AS encuesta, ${alcances[$i]}.Nombre AS alcance FROM Encuesta
            INNER JOIN ${alcances[$i]} ON Encuesta.${alcances[$i]}_id${alcances[$i]} = ${alcances[$i]}.id${alcances[$i]}
            INNER JOIN Datos_Escolares ON ${alcances[$i]}.id${alcances[$i]} = Datos_Escolares.${alcances[$i]}_id${alcances[$i]}
            INNER JOIN Usuario ON Datos_Escolares.Usuario_idUsuario = Usuario.idUsuario
            WHERE Usuario.idUsuario = '$idUsuario'";

    $res = mysqli_query($conn, $sql);

    if(gettype($res) != "boolean") {
        while($fila = mysqli_fetch_array($res)) {
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