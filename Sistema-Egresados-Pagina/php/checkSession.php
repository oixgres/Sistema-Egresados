<?php
    session_start();

    if(isset($_COOKIE["token"]) || isset($_SESSION["token"]) || isset($_SESSION['token'])){
        /* Si la cookie y session no coinciden o si no existe session*/
        if($_COOKIE["token"] != $_SESSION["token"] || !isset($_SESSION['token']))
        {
            //header('Content-Type: application/json');
            echo json_encode(['location'=>'../index.html']);
        }
        else
            /* Si el tipo de usuario no coincide */
            if($_COOKIE["userType"] != $userType)
            {
                //header('Content-Type: application/json');
                echo json_encode(['location'=>'../html/denied.html']);
            }

    }
    else{
        echo json_encode(['location'=>'../html/denied.html']);
    }




?>