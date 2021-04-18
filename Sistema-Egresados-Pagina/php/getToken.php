<?php
if(isset($_SESSION['token']))
    echo $_SESSION['token'];
else
    echo -1;