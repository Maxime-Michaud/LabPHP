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
      function modifierService(row) {
      $.ajax({
           type: "POST",
           url: './partial/modService.php',
           data:{'row':row,
               'titre':document.getElementsByName("titre")[0].value,
           'description':document.getElementsByName("description")[0].value,
           'heure':document.getElementsByName("heure")[0].value,
           'montant':document.getElementsByName("montant")[0].value,
           'actif':document.getElementsByName("actif")[0].checked,
           'image':document.getElementsByName("image")[0].src},
           success:function(html) {
             window.location.href = "./services.php";
           }
      });
 }
</script>
<!--Excel débutant-->
<?php
function afficherUnePromo($row){
    echo '<article2>';
    echo '<h1>Vous pouvez maintenant modifier les informations du service</h1>';
    echo '<p class="redReminder">Tous les champs sont obligatoires</p>';
    echo '<div class="image">';
    echo '<img name="image" class="cours" src="./images/services/'.$row[6].'">';
    echo '<div class="divCamera">Mettre à jour la photo </div>';
    echo '<div class="divCamera"><img class="camera" src="./images/icones/camera.png"></div>';
    echo '</div>';
    echo '<div class="aCoteImage">';
    echo '<input name="titre" type="text" value="'.$row[1].'"/>';
    echo '<textarea name="description" rows="5">'.$row[2].$row[3].'</textarea>';
    echo '<input name="heure" type="text" style="width:45%;" value="'.$row[3].'h"/>';
    echo '<input name="montant" type="text" style="width:45%;" value="'.$row[4].'$"/>';
    echo '</div>';
    echo '<div style="text-align:right;vertical-align:bottom;"><input name="actif" style="vertical-align:bottom; width:10%" type="checkbox" value="1" checked><label for="activer">Activer le service dans le catalogue</label></div>';
    echo '<div style="text-align:right"><input name="soumettre" onclick="modifierService(\''.addslashes($_GET['row']).'\')" type="submit" value="Confirmer" class="button"></div>';
    echo '</article2>';
}

//$row = explode(",", $_GET);
$test = explode("|",$_GET['row']);
afficherUnePromo($test);
?>
        
