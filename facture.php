<?php session_start(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facture</title>
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./styles/facture.css">
    </head>
    <body>
<?php 
include_once('includes/functions.php');
include('includes/header.php');

$factures = GetFactures();

while($facture = mysql_fetch_assoc($factures))
{
    include('partial/facture.php');
}

?>
</body>
</html>