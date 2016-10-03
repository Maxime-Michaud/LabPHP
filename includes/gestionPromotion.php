<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div style="text-align: right;padding:20px;"><a href="./AjouterPromotion.php" style="text-align: right;">Ajouter une promotion</a></div>
    <?php
include_once("functions.php");
if (isset($_SESSION['user']))
{
    get_promotion();
}
else 
{
    echo '<p>Veuillez vous identifiez pour modifier les promotion</p>';
}

function get_promotion(){
    $query = "SELECT * FROM promotion";
    $rs = mysql_query($query);
    while ($row = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        afficherUnePromo($row);
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

<?php
function afficherUnePromo($row){
    echo '<article>';
    echo '<div class="triangle dropdown">'
    . '<div class="dropdown-content">'
            . '<div type="submit" class="menu" onclick="">Appliquer à tous les services</div>'
            . '<div class="menu" onclick="">Modifier la promotion</div>'
            . '<div class="menu" onclick="">Supprimer la promotion</div>'
            . '</div></div>';
    echo "<div class='titre'><input type=text class=\"titrePromo\" disabled=\"disabled\" value=\"".$row["promotion_titre"]."\"></div>";
    $rabais = $row["rabais"]*100;
    echo '<div style="text-align:right;width:35%;">'.$rabais.'%</div>';
    echo '</article>';
}
?>
        

