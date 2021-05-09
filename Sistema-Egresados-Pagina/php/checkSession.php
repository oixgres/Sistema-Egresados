<?php

    session_start();
    $userType = $_POST['userType'];

    /* Si la cookie y session no coinciden o si no existe session*/
    if($_COOKIE["token"] != $_SESSION["token"] || (!isset($_SESSION['token']) && !isset($_COOKIE['verification'])))
    {
        echo json_encode(Array(
            'location' => '../index.html'
        ));

    }
    else
        /* Si el tipo de usuario no coincide */
        if($_COOKIE["userType"] != $userType)
        {
            if($userType=='new')
            {
                echo json_encode(Array(
                    'location' => '../index.html'
                ));
            }
            else
            {
                echo json_encode(Array(
                    'location' => '../html/denied.html'
                ));
            }
        }
?>