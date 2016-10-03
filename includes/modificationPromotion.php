<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
include_once("functions.php");
?>
<script>
function ajouterPromotion(row) {      
    $.ajax({
         type: "POST",
         url: './partial/ajPromo.php',
         data:{'fk_service':row,
             'date_debut':document.getElementsByName("date_debut")[0].value,
         'date_fin':document.getElementsByName("date_fin")[0].value,
         'code':document.getElementsByName("code")[0].value,
         'nomPromo':document.getElementsByName("titrePromo")[0].value,
         'numPromo':document.getElementsByName("hiddenNoPromo")[0].value},
         success:function(html) {
          window.location.href = "./services.php";
         }
    });
  }
  
function modifierTitre(titre, pourcent, numPromo)
  {
      document.getElementsByName("titrePromo")[0].value = titre;
      var pourcentage = pourcent * 100;
      document.getElementsByName("pourcentage")[0].innerHTML = pourcentage+"%";
      document.getElementsByName("hiddenNoPromo")[0].value = numPromo;
  }
  
function modifierPromotion(row) {
    $.ajax({
         type: "POST",
         url: './partial/modPromo.php',
         data:{'row':row,
             'date_debut':document.getElementsByName("date_debut")[0].value,
         'date_fin':document.getElementsByName("date_fin")[0].value,
         'code':document.getElementsByName("code")[0].value,
         'nomPromo':document.getElementsByName("titrePromo")[0].value,
         'numPromo':document.getElementsByName("hiddenNoPromo")[0].value},
         success:function(html) {
           window.location.href = "./services.php";
         }
    });
 }
</script>
<?php
if(isset($_GET['row']))
{
    $rowGet = explode("|",$_GET['row']);
    if(isset($rowGet[2]))
    {
        $query = "SELECT * FROM promotion WHERE pk_promotion =".$rowGet[1];
        $rs = mysql_query($query);
        $promotion = mysql_fetch_assoc($rs);
        afficherUnePromo($rowGet, $promotion);
    }
    else
    {
        $nothing = false;
        afficherUnePromo($nothing, $_GET['row']);
    }
}


function afficherUnePromo($row, $promotion){
    echo '<article2>';
    //Si une promotion a été passé en paramètre
    if($row)
    {
        echo '<h1>Appliquer les modification et appuyer sur confirmer</h1>';
    }
    else
    {
        echo '<h1>Ajouter la période et un code pour appliquer la promotion choisie</h1>';
    }
    echo '<p class="redReminder">Le code n\'est pas obligatoire et ne sera pas exigé si le champ est vide</p>';
    echo '<div class="divPromoTitrePourcent">';
    echo '<form action="./partial/uploadImage.php"  enctype="multipart/form-data" name="upload_form" method="POST">';
    if($row)
    {
        echo '<input type="hidden" id="hiddenNoPromo" name="hiddenNoPromo" value="'.$promotion['pk_promotion'].'">';

    }
    else
    {
        echo '<input type="hidden" id="hiddenNoPromo" name="hiddenNoPromo" value="'.$promotion.'">';

    }
    //Pour ne pas perdre la variable row
    if($row)
    {
        echo '<input type="hidden" id="row" name="row" value="'.$_GET['row'].'">';
    }
    else
    {
        echo '<input type="hidden" id="row" name="row" value="false">';
    }
    
    echo '<div name="pourcentage" class="divPourcent">';
    if($row)
    {
        $rabaisTemp = $promotion['rabais'] * 100;
        echo $rabaisTemp.'%';
    }
    else
    {
        echo '0%'; 
    }
    echo '</div>';
    if($row)
    {
        echo '<div class="divPromoTitre"><input type"text" name="titrePromo" disabled="disabled" value="'.$promotion['promotion_titre'].'"></label> </div>';
    }
    else
    {
        echo '<div class="divPromoTitre"><input type"text" name="titrePromo" disabled="disabled" value=""></label> </div>';

    }
    echo '<div class="divPromoTitre2 dropdown">'
    . '<div class="dropdown-content">';
    $query = "SELECT * FROM promotion";
    $rs = mysql_query($query);
    while ($rowPromo = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        echo '<div class="menu" onclick="modifierTitre(\''.addslashes($rowPromo['promotion_titre']).'\',\''.$rowPromo['rabais'].'\',\''.$rowPromo['pk_promotion'].'\')">'.$rowPromo['promotion_titre'].'</div>';
    }
    echo '</div>';
    echo '<p>▼</p></div></div>';
    echo '</form></div>';
    echo '<div class="aCoteImage">';
    //période de la promotion
    echo '<p>Période de la promotion</p>';
    //Date début
    if($row)
    {
        echo '<input class="dateInput"  name="date_debut" type="text" value="'.$row[3].'"/>';
    }
    else
    {
        echo '<input class="dateInput"  name="date_debut" type="text" value="Date de début">';
    }
    echo 'à';
    //Date de fin
    if($row)
    {
        echo '<input class="dateInput"  name="date_fin" type="text" value="'.$row[4].'"/>';
    }
    else
    {
        echo '<input class="dateInput"  name="date_fin" type="text" value="Date de fin">';
    }
    //Code
    echo 'Entrer un code s\'il est requis pour appliquer la promotion lors de la création de la facture';
    if($row)
    {
        echo '<input name="code" type="text" style="width:45%;" value="'.$row[5].'"/>';
    }
    else
    {
        echo '<input name="code" type="text" style="width:45%;" value="">';
    }
    echo '</div>';
    if($row)
    {
        echo '<div style="text-align:right"><input name="soumettre" onclick="modifierPromotion(\''.addslashes($_GET['row']).'\')" type="submit" value="Confirmer" class="button"></div>';
    }
    else
    {
        echo '<div style="text-align:right"><input name="soumettre" onclick="ajouterPromotion(\''.$promotion.'\')" type="submit" value="Confirmer" class="button"></div>';
    }
    
    echo '</article2>';
}

?>
        
