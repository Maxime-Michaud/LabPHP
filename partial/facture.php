<?php 
//Quitte si la facture n'est pas chargée
if (!isset($facture))
{
    return;
}

?>
<div class="facture">
    <?php 
    echo '<div class="num">'.$facture['num'].'</div>';
    echo '<div class="nom">'.$facture['nom'].'</div>';
    echo '<div class="date>"'.$facture['date'].'</div>';
    echo '<div class="col-offset-1 confirm>'.$facture['confirm'].'</div>';
    echo '<div class="prix">'.number_format($facture['prix'], 2).'</div>';
    ?>
    <div class="col-2 detail">Détail</div>
</div>