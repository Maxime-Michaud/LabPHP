<?php session_start(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facture</title>
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./styles/facture.css">
        <script src="http://code.jquery.com/jquery-3.1.1.min.js"
			    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			    crossorigin="anonymous"></script>
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

<script src="scripts/facture.js"></script>
</body>
</html>