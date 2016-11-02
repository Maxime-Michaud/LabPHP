<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<div style="text-align: right;padding:20px;">
    <button class="btnAjouter" id="myBtn">Ajouter un service</button></div>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      
    <div  id="modal-content" class="modal-body">
      <span class="close">×</span>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
          $.ajax({
           type: "POST",
           url: './includes/ajouterModifierService.php',
           data:{},
           success:function(html) {
               document.getElementById("modal-content").innerHTML = html;}
      });
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    function modifierService(row) {
      $.ajax({
           type: "POST",
           url: './partial/modService.php',
           data:{'row':row,
               'titre':document.getElementsByName("titre2")[0].value,
           'description':document.getElementsByName("description2")[0].value,
           'heure':document.getElementsByName("heure2")[0].value,
           'montant':document.getElementsByName("montant2")[0].value,
           'actif':document.getElementsByName("actif")[0].checked,
           'image':document.getElementsByName("image")[0].src},
           success:function(html) {
             window.location.href = "./services.php";
           }
      });
    }
      
    function modifierService2(row) {
          modal.style.display = "block";
          $.ajax({
           type: "POST",
           url: './includes/ajouterModifierService.php?row='+row,
           data:{},
           success:function(html) {
               document.getElementById("modal-content").innerHTML = html;}
      });
        }

    function panierModal(row) {
          modal.style.display = "block";
          $.ajax({
           type: "POST",
           url: './includes/panier.php?row='+row,
           data:{},
           success:function(html) {
               document.getElementById("modal-content").innerHTML = html;}
      });
        }
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
        
        function modifierPromotion2(row) {
                      modal.style.display = "block";
          $.ajax({
           type: "POST",
           url: './includes/modificationPromotion.php?row='+row,
           data:{},
           success:function(html) {
               document.getElementById("modal-content").innerHTML = html;}
      });
        }
        
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
          location.reload();
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
           location.reload();
         }
    });
 }
</script>

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
    echo '<div class="imgPromo borderNoir"';
    if($promoFini)
    {
        echo ' style="opacity: 0.20;"';
    }
    echo '>';
    echo '<div class="triangle2 dropdown">'
    . '<div class="dropdown-content">'
            . '<div type="submit" class="menu" onclick="modifierPromotion2(\''.$rowAPasser.'\')">Modifier la promotion</button></div>'
            . '<div class="menu" onclick="supprimerPromotion('.$numpromo.')">Supprimer la promotion</div>'
            . '</div></div>';
    echo '<div class="pourcent">'.$rabais.'%</div>'
    . '<div class="textBasPromo">PROMO CODE</div></div>';
}
?>
<script>

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
            . '<div id="myBtn2" class="menu" onclick="modifierService2(\''.$rowToString.'\')">Modifier le service</button></div>'
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
        echo  '<div onclick="panierModal(\''.$rowToString.'\')"> <img style="width:40px;height:40px;" src="./images/icones/panier.png"></div></div>';
        echo  '<br>';
        echo  '<div class="promos">'; 
        echo  '<div class="col-3" style="vertical-align: top;margin-right: 30px;">Promotion:</div>';
        echo  '<div class="col-8">';

        getAfficherPromotion($row["pk_service"]);
        echo    '<div style="display:inline-block;" onclick="modifierPromotion2(\''.$row['pk_service'].'\')"><img src=./images/icones/plus.png class="imgPromo"></div>';
        //echo    '<div class="fb-share-button" data-href="http://weba.cegepsherbrooke.qc.ca/~tia16007/services.php" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fweba.cegepsherbrooke.qc.ca%2F%7Etia16007%2Fservices.php&amp;src=sdkpreparse">Share</a></div>';
        //echo '<a href="https://twitter.com/intent/tweet?screen_name=TwitterDev" class="twitter-mention-button" data-text="Super promotion!" data-show-count="false">Tweet to @TwitterDev</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
        //echo '<div class="g-plus" data-action="share" data-href="http://weba.cegepsherbrooke.qc.ca/~tia16007/services.php"></div>';
        echo    '<img src=./images/icones/medias.jpeg class="imgPromo" usemap="#Share" style="float: right;margin-right: -10px;">';
        echo  '  <map name="Share">
                    <area shape="circle" coords="11,43,12" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fweba.cegepsherbrooke.qc.ca%2F%7Etia16007%2Fservices.php&amp;src=sdkpreparse" alt="Facebook">
                    <area shape="circle" coords="49,43,12" alt="Google+">
                    <area shape="circle" coords="30,17,12" href="https://twitter.com/intent/tweet?screen_name=TwitterDev" class="twitter-mention-button" data-text="Super promotion!" data-show-count="false">
                 </map>';
        echo '</div>';
        echo '</div>';
        echo '<div style="floar:right;" class="g-plus" data-action="share" data-href="http://weba.cegepsherbrooke.qc.ca/~tia16007/services.php"></div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</article>';
}
?>

<button type="button" onclick="reactiverTout()">Réactiver tout</button>
        
