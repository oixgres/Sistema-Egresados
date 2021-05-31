<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	idAlcance    : INT
 *  tipoAlcance  : INT
 *		[0 - Universidad    ]
 *		[1 - Campus         ]
 *	  	[2 - Facultad       ]
 *    	[3 - Plan academico ]
 *
 * Devuelve:
 * 	0 : Operacion correcta
 *
 *  Códigos de error:
 *  -1 : No se mandó el alcance
 *  -2 : Error en consulta de usuarios
 *  -3 : Error en envio de uno o mas correos
*/

if (isset($_POST['idAlcance']) && isset($_POST['tipoAlcance'])) {
    $idAlcance = $_POST['idAlcance'];
    $tipoAlcance = $_POST['tipoAlcance'];
} else {
    echo -1;
    $conn->close();
    exit();
}

$nombresAlcance = array("Universidad", "Campus", "Facultad", "Plan_Estudio");
$llavesAlcance = array("Universidad_idUniversidad", "Campus_idCampus", "Facultad_idFacultad", "Plan_Estudio_idPlan_Estudio");

$sql = "SELECT Usuario.Correo, Usuario.Nombres, ${nombresAlcance[$tipoAlcance]}.Nombre
        FROM Usuario
        INNER JOIN Datos_Escolares ON Usuario.idUsuario = Datos_Escolares.Usuario_idUsuario
                                  AND Datos_Escolares.${llavesAlcance[$tipoAlcance]} = ${idAlcance}
        INNER JOIN ${nombresAlcance[$tipoAlcance]} ON ${nombresAlcance[$tipoAlcance]}.id${nombresAlcance[$tipoAlcance]} = $idAlcance";

$res = mysqli_query($conn, $sql);
if (gettype($res) != "boolean" and $res->num_rows > 0) {
    while($fila = mysqli_fetch_assoc($res)) {
        $users [] = array(
            'correo' => $fila['Correo'],
            'nombreUsuario'=> $fila['Nombres'],
            'nombreAlcance' => $fila['Nombre']
        );
    }
} else {
    echo -2;
    $conn->close();
    exit();
}

$ret = 0;
foreach($users as $user) {
    if (sendMail($user)) {
        $ret = -3;
    }
}

echo $ret;
$conn->close();

function sendMail($user) {
    $correoUsuario = $user['correo'];
    $asunto = "Nueva encuesta disponible";
    $mensaje = "Hola, ${user['nombreUsuario']},\r\n\r\n";
    $mensaje .= "Se ha creado una nueva encuesta en el Sistema de Egresados por parte de ${user['nombreAlcance']}. Accede en el siguiente enlace: \r\n";
    $mensaje .= "http://sistema-egresados.conisoft.org/";
    // Preparar el correo
    $header = "FROM: noreply@SistemaEgresados.com"."\r\n";
    $header.= "Reply-To: noreply@SistemaEgresados.com"."\r\n";
    $header.= "X-Mailer: PHP/".phpversion();

    if (@mail($correoUsuario, $asunto, $mensaje, $header)) {
        return 0;
    } else {
        return 1;
    }
}