<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Services</title>
        <meta charset="UTF-8">
        <link href="./styles/style.css" rel="stylesheet" type="text/css">
        <link href="./styles/services.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php 
            include('./includes/header.php'); 
            echo '<main>';
            include('./includes/services.php');
            echo '</main>';
        ?>
    </body>
    
</html>
