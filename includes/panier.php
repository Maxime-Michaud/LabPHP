<?php
function ajouterAuPanier()
{
    $_SESSION[$_SESSION["nbItemPanier"]."a"] = $_GET['row'];
    $_SESSION["nbItemPanier"]= $_SESSION["nbItemPanier"] + 1;

}

$rowGet = explode("|",$_GET['row']);
var_dump($_SESSION["nbItemPanier"]);
echo '<div style="border: 2px solid #FF9F07;">'.
        '<h1>'.$rowGet[1].'</h1>';
echo $rowGet[4].'$ <br>';
echo $rowGet[2];
echo '<input type="button" value="Ajouter au panier" onclick="ajouterAuPanier" class="button">';
