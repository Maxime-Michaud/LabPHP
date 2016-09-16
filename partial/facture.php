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
    echo '<div class="vertical">';
    echo    '<div class="nom">'.$facture['nom'].'</div>';
    echo    '<div>'.$facture['confirm'].'</div>';
    echo '</div>';
    echo '<div class="vertical right">';
    echo    '<div class="date">'.$facture['date'].'</div>';
    echo    '<div>'.number_format($facture['prix'], 2).'$</div>';
    echo '</div>';
    ?>
    <div class="detail">Détail</div>
</div>