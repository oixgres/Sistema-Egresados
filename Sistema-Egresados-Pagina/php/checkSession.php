<?php

    session_start();
    $userType = $_POST['userType'];

    /* Si la cookie y session no coinciden o si no existe session*/
    if($_COOKIE["token"] != $_SESSION["token"] || !isset($_SESSION['token']))
    {
        header("Location: ../index.html");
        exit();
    }
    else
        /* Si el tipo de usuario no coincide */
        if($_COOKIE["userType"] != $userType)
        {
            if($userType=="new")
            {
              header("Location: ../index.html");
              exit();
            }
            else
            {
              header("Location: ../html/denied.html");
              exit();
            }
        }
?>
