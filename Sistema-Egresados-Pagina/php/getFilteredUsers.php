<?php
require_once "dbh.php";
/*
 * Recibe:
 * 	Campus : VARCHAR(45)		
 *	Facultad : VARCHAR(45)	
 *	Plan_Estudio : VARCHAR(45)	
 *	Empresa : VARCHAR(45)
 *  Puesto : VARCHAR(45)
 *	Ciudad : VARCHAR(45)
 *	Nombres : VARCHAR(45)
 *	Apellidos : VARCHAR(45)
 *	IdAdmin : INT
 * 
 * Devuelve:
 * 	Todas los usuarios que empiecen o contengan valores iguales a los recibidos.
 * 
 *  (JSON)
 *	idUsuario : INT
 *  Matricula : INT
 *	Nombres : VARCHAR(45)
 *	Apellidos : VARCHAR(45)
 *  Campus : VARCHAR(45)
 *	Facultad : VARCHAR(45)
 *	Plan_Estudio : VARCHAR(45)
 *  Empresa : VARCHAR(45)
 *	Puesto : VARCHAR(45)
 *  Ciudad : VARCHAR(45)
 +	Correo : VARCHAR(45)
 *  
 *  
 *	Notas: 
 *	- Si en campus, facultad, plan_estudio,empresa, ciudad,
 *	nombre o apellidos les llega un "N_A", no se filtran esos
 *  campos.
 *	- Si todos los campos son "N_A", se regresan todos los alumnos.
 *     
 *  Códigos de error:
 *	-1: No se mandó alguno de los datos en _POST
 *	-2: El id del Administrador no es valido/esta registrado.
 *	-3: Hubo un error preparando la consulta/la consulta contiene un error.
 *	-4: Hubo un error ejecutando la consulta.
 *	-5: El JSON final está vacio.
 *  -6: El administrador no tiene una universidad registrada.
*/

//Nombres que nos da el front end para las variables _POST a excepcion
// del admin, el cual se comprueba despues.
				
$indices_post = array(
"Campus",
"Facultad",
"Plan_Estudio",
"Empresa",
"Puesto",
"Ciudad",
"Nombres",
"Apellidos"
);

$campos_recibidos = array();

foreach($indices_post as $indice) 
{
	if(!isset($_POST[$indice])) 
	{
		echo -1;		//No se mandó alguno de los campos el POST
		$conn->close();
		exit();
	} 
	else 
	{
		//Con estos campos se hace el WHERE de la consulta
		$campos_recibidos [] = '%'.$_POST[$indice].'%';
		//Se concatenan lso '%' por la naturaleza de la consulta.
		// "...empiecen o << contengan >> valores iguales a los recibidos."
	}
}

 //Aqui verifico que el administrador este registrado en la tabla.
if(!isset($_POST['IdAdmin']))
{
	echo -1;		//No se mandó alguno de los datos en _POST
	$conn->close();
	exit();
}
else
{
	$idAdmin = $_POST['IdAdmin'];
	$sql = "SELECT idAdmin FROM Admin WHERE idAdmin = $idAdmin";
	$admin_exists = $conn->query($sql);
	
	if($admin_exists->num_rows == 0)	//Si la busqueda no devuelve
	{									// resultados...
		echo -2;		//No es un id de administrador valido
		$conn->close();
		exit();
	}
	
	$sql = "SELECT Universidad_idUniversidad FROM Admin WHERE idAdmin = $idAdmin";
	$alcance_admin = $conn->query($sql);
	
	if($alcance_admin->num_rows == 0)	//Si la busqueda no devuelve
	{									// resultados...
		echo -6;		//No es un id de administrador valido
		$conn->close();
		exit();
	}
}	

//Estas son las tablas y columnas para los resultados que voy a devolver
$tablas = array(
"Usuario",
"Usuario",
"Usuario",
"Usuario",
"Campus",
"Facultad",
"Plan_Estudio",
"Datos_Laborales",
"Datos_Laborales",
"Ciudad",
"Usuario"
);
						
$columnas = array(
"idUsuario",
"Matricula",
"Nombres",
"Apellidos",
"Nombre",
"Nombre",
"Nombre",
"Empresa",
"Puesto",
"Nombre",
"Correo"
);
					
/*
Se iteran las tablas y columnas para formar la parte de la sentencia
SQL del SELECT
*/					

$sql_select = "SELECT ";

$num_columnas = count($columnas);

for($i = 0; $i < $num_columnas; $i++)
{
	$sql_select .= "${tablas[$i]}.${columnas[$i]}";
	
	if($i < $num_columnas - 1)
	{
		$sql_select .= ", ";
	} else {
		$sql_select .= " ";
	}
}

/*
Los joins deben ser manuales por que pueden involucrar tablas en la
 base de datos que no esten relacionadas directamente con los campos 
 que se piden.
*/
				
$sql_joins = "FROM Usuario 
			  LEFT JOIN Datos_Escolares ON Usuario.idUsuario = Datos_Escolares.Usuario_idUsuario
			  LEFT JOIN Campus ON Datos_Escolares.Campus_idCampus = Campus.idCampus
			  LEFT JOIN Facultad ON Datos_Escolares.Facultad_idFacultad = Facultad.idFacultad
			  LEFT JOIN Plan_Estudio ON Datos_Escolares.Plan_Estudio_idPlan_Estudio = Plan_Estudio.idPlan_Estudio
			  LEFT JOIN Datos_Laborales ON Usuario.idUsuario = Datos_Laborales.Usuario_idUsuario
			  LEFT JOIN Datos_Personales ON Usuario.idUsuario = Datos_Personales.Usuario_idUsuario
			  LEFT JOIN Ciudad ON Datos_Personales.Ciudad_idCiudad = Ciudad.idCiudad ";

/*
Estas son las tablas y las columnas para los campos que se recibieron
por medio del _POST
*/

$tablas_where = array(
"Campus",
"Facultad",
"Plan_Estudio",
"Datos_Laborales",
"Datos_Laborales",
"Ciudad",
"Usuario",
"Usuario"
);
						
$columnas_where = array(
"Nombre",
"Nombre",
"Nombre",
"Empresa",
"Puesto",
"Nombre",
"Nombres",
"Apellidos"
);

//Aqui se crea la parte de la consulta para el WHERE

$sql_where = ''; 

$condiciones = array();

$num_campos = count($campos_recibidos);

//Esto se usa para que las consultas preparadas sepan el tipo de datos
// que va a manejar. Idealmente se enviarian los tipos de datos junto
// con el nombre de los campos desde el front end, pero por el momento,
// todos los que se envian actualmente son string, asi que solo se 
// concatenan 's' por cada condicion que se vaya a aplicar.
$tipo_campo = '';

for($i = 0; $i < $num_campos; $i++)
{
	//Si el campo recibido es igual a N_A, entonces se omite en el WHERE
	if(strcasecmp($campos_recibidos[$i],'%N_A%') != 0)
	{
		if(empty($sql_where))
		{
			//Si es la primera vez que encuentra una condicion valida
			// se agrega el where. Si nunca se encuentra una condicion
			// valida, la consulta se realiza directamente sin WHERE.
			$sql_where = 'WHERE ';
		}
		
		if(count($condiciones) > 0 )		//Si ya hay condiciones en el array...
		{
			$sql_where .= ' AND ';	//Se concatena un AND para la siguiente condicion
		}
		
		$sql_where .= "${tablas_where[$i]}.${columnas_where[$i]} LIKE ?" ;
		
		$condiciones[] = $campos_recibidos[$i];
		
		$tipo_campo .= 's';
	}
}

//Solo se devuelven los usuarios que sean de la misma universidad que el administrador.

if(empty($sql_where))
{
$sql_where = ' WHERE Datos_Escolares.Universidad_idUniversidad = '.$alcance_admin->fetch_row()[0];
} 
else 
{
	$sql_where .= ' AND Datos_Escolares.Universidad_idUniversidad = '.$alcance_admin->fetch_row()[0];
}

//Se juntan todas las partes para preparar la query
//PD. Si no hubo ninguna condicion valida, sql_where esta vacio.

$sql = $sql_select . $sql_joins . $sql_where;

//Preparas la query
$stmt = $conn->prepare($sql);

if(gettype($stmt) == false)
{
	echo -3; //Hubo un error preparando la consulta/la consulta contiene un error.
	$conn->close();
	exit();
}

//Aqui se remplazan los ? en la consulta con los datos correspondientes.
// Si no hubo condiciones en la consulta, esto se omite.
if(!empty($condiciones))
{
	$stmt->bind_param($tipo_campo, ...$condiciones);
}	

$exe_status = $stmt->execute();

if($exe_status == false)
{
	echo -4; //Hubo un error ejecutando la consulta.
	$conn->close();
	exit();
}

$fila = array_fill(0, 11, 0);

//Vinculo cada posicion del array con una columna del resultado
$stmt->bind_result(...$fila); 
								
//Aqui se guardan los datos en el JSON

$json = array();

while($stmt->fetch()){
    
    $json [] = array(
        'idUsuario' => $fila[0],
        'Matricula' => $fila[1],
        'Nombres' => $fila[2],
        'Apellidos' => $fila[3],
        'Campus' => $fila[4],
        'Facultad' => $fila[5],
        'Plan_Estudio' => $fila[6],
        'Empresa' => $fila[7],
        'Puesto' => $fila[8],
        'Ciudad' => $fila[9],
        'Correo' => $fila[10]
    );
    
}


echo json_encode($json);

/*
 *	JSON final:
 *	(JSON)
 *	idUsuario : INT ... 'idUsuario' => 14
 *  Matricula : INT ... 'Matricula' => 1256435s
 *	Nombres : VARCHAR(45) ... 'Nombres' => 'Juan'
 *	Apellidos : VARCHAR(45) ... 'Apellidos' => 'Camaney'
 *  Campus : VARCHAR(45)
 *	Facultad : VARCHAR(45)
 *	Plan_Estudio : VARCHAR(45)
 *  Empresa : VARCHAR(45)
 *	Puesto : VARCHAR(45)
 *  Ciudad : VARCHAR(45)
 *  Correo : VARCHAR(45)
*/

/*

if(!empty($json)) 
{
	echo json_encode($json); 	//convertir el json a cadena
						//retornar el json al frontend
} else {
 	echo -5; 		//El json está vacio
}

*/

$conn->close();
?>