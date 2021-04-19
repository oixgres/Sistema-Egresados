<?php
  session_start();

  /* Destruimos la sesion */
  session_destroy();

  /*  Eliminamos el contenido de las cookies */
  setcookie("token", "",time()-1, "/");
  setcookie("name", "", time()-1,"/");
  setcookie("lastname", "", time()-1,"/");
  setcookie("mail", "", time()-1,"/");
  setcookie("id",  "", time()-1,"/");

  header("Location: ../index.html");
  exit();
?>
