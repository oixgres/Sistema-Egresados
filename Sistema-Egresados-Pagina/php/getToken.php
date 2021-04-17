<?php
$token = sha1(uniqid(rand(10000000,99999999), true));
$_SESSION['token'] = $token;
echo $_SESSION['token'];