<?php
session_start();

echo "Bienvenido: ".$_COOKIE["name"];
echo "Su token en cookie es: ".$_COOKIE["token"];
echo "Su token en el servidor es: ".$_SESSION["token"];

 ?>
