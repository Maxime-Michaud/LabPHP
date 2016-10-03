<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div style="text-align: right;padding:20px;"><a href="./modifAjoutService.php" style="text-align: right;">Ajouter un service</a></div>
    <?php
include_once("functions.php");
if (isset($_SESSION['user']))
{
    get_produit();
}
else 
{
    echo '<p>Veuillez vous identifiez pour modifier les produits</p>';
}

function get_produit(){
    $query = "SELECT * FROM service";
    $rs = mysql_query($query);
    while ($row = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        if($row['actif']==1)
        {
            afficherUnePromo($row);
        }

    }
}

function getAfficherPromotion($numero){
    $query = "SELECT * FROM ta_promotion_service";
    $rs = mysql_query($query);
    while ($row = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        if($row["fk_service"] == $numero)
        {
            afficherUnRabais($row["fk_promotion"]);
        }   
    }
}

function afficherUnRabais($numero)
{
    $query = "SELECT * FROM ta_promotion_service WHERE fk_promotion =".$numero;
    $rs = mysql_query($query);
    $row = mysql_fetch_assoc($rs);
    $numpromo = $row["pk_promotion_service"];
    $rowAPasser = addslashes(implode("|",$row));
    $promoFini = FALSE;
    if($row == NULL)
    {
        return;
    }
    else
    {
        if(strtotime($row["date_fin"]) <= strtotime("now"))
        {
            $promoFini = TRUE;
        }
        $query = "SELECT * FROM promotion WHERE pk_promotion =".$row["fk_promotion"];
        $rs = mysql_query($query);
        $row = mysql_fetch_assoc($rs);
    } 
    $rabais = $row["rabais"] * 100;
        if($promoFini)
    {
        echo '<img src="./images/icones/diagonal.gif" class="diagonal">';
    }
    echo '<div class="imgPromo"';
    if($promoFini)
    {
        echo ' style="opacity: 0.20;"';
    }
    echo '>';
    echo '<div class="triangle2 dropdown">'
    . '<div class="dropdown-content">'
            . '<div type="submit" class="menu" onclick="modifierPromotion(\''.$rowAPasser.'\')">Modifier la promotion</button></div>'
            . '<div class="menu" onclick="supprimerPromotion('.$numpromo.')">Supprimer la promotion</div>'
            . '</div></div>';
    echo '<div class="pourcent">'.$rabais.'%</div>'
    . '<div class="textBasPromo">PROMO CODE</div></div>';
}
?>
<script>
      function desactiverService($id) {
      $.ajax({
           type: "POST",
           url: './partial/activationService.php',
           data:{'id':$id,'reactivate':'non'},
           success:function(html) {
             location.reload();
           }

      });
 }
 
       function supprimerPromotion($id) {
      if(confirm("Voulez-vous vraiement supprimer cette promotion?"))
      {
      $.ajax({
           type: "POST",
           url: './partial/supprimerPromotion.php',
           data:{'id':$id},
           success:function(html) {
             location.reload();
           }

      });
      }
 }
 
       function reactiverTout($id) {
      $.ajax({
           type: "POST",
           url: './partial/activationService.php',
           data:{'reactivate':'oui'},
           success:function(html) {
             location.reload();
           }

      });
 }
         function modifierService(row) {
             window.location.href = "./modifAjoutService.php?row="+row;
        }
        
        function modifierPromotion(row) {
             window.location.href = "./modifPromo.php?row="+row;
        }
        
</script>

<!--Excel débutant-->
<?php
function afficherUnePromo($row){
    $rowToString = addslashes(implode("|",$row));
    echo '<article>';
    echo '<img class="cours" src="./images/services/'.$row['image'].'">';

    echo '<div class="reste">';
    echo '<div class="triangle dropdown">'
    . '<div class="dropdown-content">'
            . '<div type="submit" class="menu" onclick="modifierService(\''.$rowToString.'\')">Modifier le service</button></div>'
            . '<div class="menu" onclick="desactiverService('.$row['pk_service'].')">Désactiver le service</div>'
            . '</div></div>';
    echo "<div class='titre'>".$row["service_titre"]."</div>";
    
    echo '<p>'.$row["service_description"].'</p>';

    echo  '<div class="row"><div class="tarif">Tarif: '.$row["tarif"].'$'.'</div>';
    echo  '<div class="dure">Durée: '.$row["duree"].'H'.'</div>';

//    if(isset($_SESSION["client"]))
    if(false)
    {
        echo  '<img class="panier" src="./images/icones/panier.png"></div>';
    }
    else 
    {
        echo  '<img class="panier" src="./images/icones/panier.png" style="visibility:hidden"></div>';
        echo  '<br>';
        echo  '<div class="promos">'; 
        echo  '<div class="col-3" style="vertical-align: top;margin-right: 30px;">Promotion:</div>';
        echo  '<div class="col-8">';

        getAfficherPromotion($row["pk_service"]);
        echo    '<div style="display:inline-block;" onclick="modifierPromotion(\''.$row['pk_service'].'\')"><img src=./images/icones/plus.png class="imgPromo"></div>';
        echo    '<img src=./images/icones/medias.jpeg class="imgPromo" style="float: right;margin-right: -10px;">';
        echo    '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</article>';
}
?>

<button type="button" onclick="reactiverTout()">Réactiver tout</button>
        