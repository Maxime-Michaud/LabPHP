<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
include_once("functions.php");

function afficherUnRabais($numero)
{
    $query = "SELECT * FROM ta_promotion_service WHERE fk_promotion =".$numero;
    $rs = mysql_query($query);
    $row = mysql_fetch_assoc($rs);
    if($row == NULL)
    {
        return;
    }
    else
    {
        $promoFini = FALSE;
        if(strtotime($row["date_fin"]) <= strtotime("now"))
        {
            $promoFini = TRUE;
        }
        $query = "SELECT * FROM promotion WHERE pk_promotion =".$row["fk_promotion"];
        $rs = mysql_query($query);
        $row = mysql_fetch_assoc($rs);
    } 

    if($row["rabais"] == '0.10')
    {
        echo '<img src=./images/promotions/10.png ';if(!$promoFini){echo 'class="imgPromo"';}else{echo 'class="promoFini"';};echo '>';
    }
    else if($row["rabais"] == '0.15')
    {
        if($promoFini)
        {
            echo "<div class=\"promoFini\" style=\"background-image: url('images/promotions/15.png');\">&nbsp;/&nbsp;&nbsp;</div>";
        }
        else
        {
            echo '<img src=./images/promotions/15.png ';if(!$promoFini){echo 'class="imgPromo"';}else{echo 'class="promoFini"';};echo '>';
        }
    }
    else if($row["rabais"] == '0.20')
    {
        echo '<img src=./images/promotions/20.png ';if(!$promoFini){echo 'class="imgPromo"';}else{echo 'class="promoFini"';};echo '>';
    }
    else if($row["rabais"] == '0.25')
    {
        echo '<img src=./images/promotions/25.png ';if(!$promoFini){echo 'class="imgPromo"';}else{echo 'class="promoFini"';};echo '>';
    }
}
?>
<script>
      function desactiverService($id) {
      $.ajax({
           type: "POST",
           url: './partial/ajax.php',
           data:{'id':$id,'reactivate':'non'},
           success:function(html) {
             location.reload();
           }

      });
 }
 
       function reactiverTout($id) {
      $.ajax({
           type: "POST",
           url: './partial/ajax.php',
           data:{'reactivate':'oui'},
           success:function(html) {
             location.reload();
           }

      });
 }
</script>
<!--Excel débutant-->
<?php
function afficherUnePromo($row){
    echo '<article >';
    echo '<h1>Compléter le formulaire pour ajouter un nouveau service</h1>';
    echo '<p class="redReminder">Tous les champs sont obligatoires';
    echo '<img class="cours" style="border:2px solid black;" src="./images/services/'.$row['image'].'">';

    echo '<input type="text" class="reste">';
    echo '<div class="triangle dropdown">'
    . '<div class="dropdown-content">'
            . '<div class="menu">Modifier le service</div>'
            . '<div class="menu" onclick="desactiverService('.$row['pk_service'].')">Désactiver le service</div>'
            . '</div></div>';
    echo "<div class='titre'>".$row["service_titre"]."</div>";
    
    echo '<p>'.$row["service_description"].'</p>';

    echo  '<div class="row"><div class="tarif">Tarif: '.$row["tarif"].'$'.'</div>';
    echo  '<div class="dure">Durée: '.$row["duree"].'H'.'</div>';

    if(isset($_SESSION["client"]))
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

        get_promotion($row["pk_service"]);
        echo    '<img src=./images/icones/plus.png class="imgPromo">';
        echo    '<img src=./images/icones/medias.jpeg class="imgPromo" style="float: right;margin-right: -10px;">';
        echo    '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</article>';
}

$row = json_decode(base64_decode($_POST['row']));
var_dump($row);
afficherUnePromo($row);
?>
        
