<?php
/*Ce fichier affice les détails des services d'une facture*/
include_once('../includes/functions.php'); 

$facture = $_POST['confirmation'];

//Sélectionne la bonne facture dans la bd
$query = "  SELECT     s.service_titre AS titre, 
                       fs.tarif_facture AS tarif,
                       fs.montant_rabais AS rabais,
                       s.pk_service AS service,
                       f.date_service AS date
                FROM facture f INNER JOIN ta_facture_service fs ON f.pk_facture = fs.fk_facture
                               INNER JOIN service s ON fs.fk_service = s.pk_service
                WHERE f.no_confirmation = '$facture'";
$rs = mysql_query($query);

echo '<div class="services"> ';

while($row = mysql_fetch_assoc($rs))
{
    $query = "  SELECT p.promotion_titre AS titre
                FROM ta_promotion_service ps INNER JOIN promotion p ON p.pk_promotion = ps.fk_promotion
                WHERE '" . $row['date'] . "' BETWEEN ps.date_debut AND ps.date_fin 
                    AND ps.fk_service = " . $row['service'];
    $promo = mysql_fetch_assoc(mysql_query($query))['titre'];
    echo '<div class="service"><div>' . $row['titre'] . "</div><div>" . $row['tarif'] . "$</div><div>&nbsp;</div></div>";
    
    if ($row['rabais'] != 0)
        echo '<div class="promo"><div>' . $promo . "</div><div>- " . $row['rabais'] . "$</div><div>&nbsp;</div></div>";
}

echo '</div>';
echo '<div class="reduire">Réduire</div>';