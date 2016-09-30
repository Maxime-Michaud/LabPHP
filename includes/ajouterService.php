<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
include_once("functions.php");
?>
<script>
      function ajouterService(row) {
          
      $.ajax({
           type: "POST",
           url: './partial/ajService.php',
           data:{'titre':document.getElementsByName("titre")[0].value,
           'description':document.getElementsByName("description")[0].value,
           'heure':document.getElementsByName("heure")[0].value,
           'montant':document.getElementsByName("montant")[0].value,
           'actif':document.getElementsByName("actif")[0].checked,
           'image':document.getElementsByName("image")[0].src},
           success:function(html) {
               alert(html);
             //window.location.href = "./services.php";
           }
      });
 }
</script>
<?php
function afficherUnePromo(){
    echo '<article2>';
    echo '<h1>Compléter le formulaire pour ajouter un nouveau service</h1>';
    echo '<p class="redReminder">Tous les champs sont obligatoires</p>';
    echo '<div class="image">';
    echo '<img name="image" class="cours" src="./images/services/cours.gif">';
    echo '<div class="divCamera">Mettre à jour la photo </div>';
    echo '<div class="divCamera"><img class="camera" src="./images/icones/camera.png"></div>';
    echo '</div>';
    echo '<div class="aCoteImage">';
    echo '<input name="titre" type="text" value="Titre"/>';
    echo '<textarea name="description" rows="5">Description</textarea>';
    echo '<input name="heure" type="text" style="width:45%;" value="Durée"/>';
    echo '<input name="montant" type="text" style="width:45%;" value="Tarif"/>';
    echo '</div>';
    echo '<div style="text-align:right;vertical-align:bottom;"><input name="actif" style="vertical-align:bottom; width:10%" type="checkbox" value="1" checked><label for="activer">Activer le service dans le catalogue</label></div>';
    echo '<div style="text-align:right"><input name="soumettre" onclick="ajouterService()" type="submit" value="Confirmer" class="button"></div>';
    echo '</article2>';
}
afficherUnePromo();
?>
        
