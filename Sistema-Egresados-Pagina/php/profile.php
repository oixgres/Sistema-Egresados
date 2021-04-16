<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!-- Navbar -->
    
    </nav>
    <?php if($_COOKIE["token"] == $_SESSION["token"]): ?>

    <?php else: ?>

    <?php endif; ?>

  </body>
</html>
