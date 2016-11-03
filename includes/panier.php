<?php
session_start();
$rowGet = explode("|",$_GET['row']);
var_dump($_SESSION["nbItemPanier"]);
echo '<div style="border: 2px solid #FF9F07;">'.
        '<h1>'.$rowGet[1].'</h1>';
echo $rowGet[4].'$ <br>';
echo $rowGet[2];
echo '<input type="button" value="Ajouter au panier" onclick="ajouterAuPanier(\''.addslashes($_GET['row']).'\')" class="button">';
