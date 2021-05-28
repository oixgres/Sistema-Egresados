<?php
require_once "dbh.php";
/*
 * Recibe:
 *	idName : VARCHAR(45)
 *	idLastName : VARCHAR(45)
 *  idMat : VARCHAR(45)
 *	idMail : VARCHAR(45)
 *	idPass : VARCHAR(45)	
 *  idPass2 : VARCHAR(45)
 *
 * Devuelve:
 *	Registra un usuario en la base de datos y le envia un correo con
 *  los detalles de su registro.
 *
 * Errores:
 *  "Correo ya existente"
 *	"Error en Contraseña"
 *	"No se pudo conectar con la base de datos"
 *  "No se mando correctamente uno de los datos del registro";
*/

if($conn)
{
	if(isset($_POST['idName'])) {
		$name = $_POST['idName'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
	
	if(isset($_POST['idLastName'])) {
		$lastname = $_POST['idLastName'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
  
	if(isset($_POST['idMat'])) {
		$matricula = $_POST['idMat'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
  
	if(isset($_POST['idMail'])) {
		$email = $_POST['idMail'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
  
	if(isset($_POST['idPass'])) {
		$password = $_POST['idPass'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
  
	if(isset($_POST['idPass2'])) {
		$password2 = $_POST['idPass2'];
	} else {
		echo "No se mando correctamente uno de los datos del registro";
		$conn->close();
		exit();
	}
  

  $checkmail = mysqli_query($conn, "SELECT * FROM Usuario WHERE Correo='".$email."'");

  if(mysqli_num_rows($checkmail) > 0)
  {
    echo "Correo ya existente";
  }
  else
  {
      if($password != $password2)
      {
        echo "Error en Contraseña";
      }
      else
      {
        /* Creamos el usuario */
        mysqli_query($conn, "INSERT INTO Usuario (Correo, Password, Nombres, Apellidos, Matricula) VALUES ('$email','$password','$name','$lastname','$matricula')");

        /* Obtenemos el ID del Usuario */
        
		$asunto = 'Registro al Sistema de Seguimiento de Egresados';
		$mensaje = "Estimado usuario,\r\n\n
					
					Has sido registrado al Sistema de Seguimiento de Egresados\r\n
					por parte de tu universidad. Te invitamos a ingresar al sigiuente\r\n 
					enlace para continuar satisfactoriamente tu registro.\r\n\n
					
					Ingresa tu correo como usuario con la siguiente contraseña \r\n
					elegida por el trabajador universitario encargado de\r\n
					tu registro.\r\n\n
					
					Contraseña: '$password'\r\n\n
					
					http://sistema-egresados.conisoft.org/ \r\n\n\n
					
					
					Si crees que esto es un error, por favor ignora este mensaje.\r\n\n
					
					Esta direccion de correo es solo de envio. Por favor, contacte\r\n
					con su universidad para cualquier duda pertinente.\r\n\n
					
					El equipo del Sistema de Seguimiento de Egresados le\r\n 
					da las gracias y le desea un excelente dia.";
		
		$header = "FROM: noreply@sistema-egresados.conisoft.org"."\r\n
					Return-Path: noreply@sistema-egresados.conisoft.org"."\r\n
					Reply-To: noreply@sistema-egresados.conisoft.org"."\r\n
					Organization: Sistema de Seguimiento de Egresados"."\r\n
					Content-type: text/plain; charset=iso-8859-1\r\n
					X-Priority: 3\r\n
					X-Mailer: PHP/".phpversion();
		
		mail($email, $asunto, $mensaje, $header);
      
        $conn->close();
        exit();
      }
  }
}
else
{
  echo "No se pudo conectar con la base de datos";
}


?>