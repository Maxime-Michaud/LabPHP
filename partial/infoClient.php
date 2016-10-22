<?php 
$id = $_GET['id'];

include_once("../includes/functions.php");

$query = "SELECT concat(c.nom, ' ', c.prenom) AS nom,
                 c.telephone AS telephone,
                 concat(a.no_civique, ' ',a.rue, ', ', v.ville, ', ', a.code_postal) AS adresse
          FROM client c INNER JOIN adresse a ON c.fk_adresse = a.pk_adresse
						INNER JOIN ville v ON a.fk_ville = v.pk_ville
          WHERE c.pk_client = " . mysql_real_escape_string($id);

$rs = mysql_query($query);
$arr = mysql_fetch_assoc($rs);

echo "<table class='detailClient'";
echo "<tr><td class='nomClient'>".$arr['nom']."</td>";
echo "<td class='tel'>".$arr['telephone']."</td></tr>"; 
echo "<tr><td class='adr' colspan='2'>".$arr['adresse']."</td></tr>";
echo "</table>";