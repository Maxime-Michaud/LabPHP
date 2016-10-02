<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
include_once("functions.php");
?>
<script>
      function ajouterService(row) {      
      $.ajax({
           type: "POST",
           url: './partial/ajService.php',
           data:{'titre2':document.getElementsByName("titre2")[0].value,
           'description2':document.getElementsByName("description2")[0].value,
           'heure2':document.getElementsByName("heure2")[0].value,
           'montant2':document.getElementsByName("montant2")[0].value,
           'actif':document.getElementsByName("actif")[0].checked,
           'image':document.getElementsByName("image")[0].src},
           success:function(html) {
               alert(html);
             window.location.href = "./services.php";
           }
      });
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
</script>
<?php
function afficherUnePromo($row){
    echo '<article2>';
    //Si un service a été passé en paramètre
    if($row)
    {
        echo '<h1>Vous pouvez maintenant modifier les informations du service</h1>';
    }
    else
    {
        echo '<h1>Compléter le formulaire pour ajouter un nouveau service</h1>';
    }
    echo '<p class="redReminder">Tous les champs sont obligatoires</p>';
    echo '<div class="image">';
    echo '<form action="./partial/uploadImage.php"  enctype="multipart/form-data" name="upload_form" method="POST">';
    echo '<input type="hidden" id="titre" name="titre" value="Titre">';
    echo '<input type="hidden" id="description" name="description" value="Description">';
    echo '<input type="hidden" id="duree" name="duree" value="Durée">';
    echo '<input type="hidden" id="montant" name="montant" value="Tarif">';
    //Pour ne pas perdre la variable row
    if($row)
    {
        echo '<input type="hidden" id="row" name="row" value="'.$_GET['row'].'">';
    }
    else
    {
        echo '<input type="hidden" id="row" name="row" value="false">';
    }
    
    IF(isset($_GET['image']) &&$_GET['image'] != "")
    {
        echo '<img name="image" class="cours" src="./images/services/'.$_GET['image'].'">';
    }
    else 
    {
        if($row)
        {
            echo '<img name="image" class="cours" src="./images/services/'.$row[6].'">';
        }
        else
        {
            echo '<img name="image" class="cours" src="./images/services/cours.gif">'; 
        }
            
    }
    echo '<div class="divCamera1"><input type="submit" value="Mettre à jour la photo"> </div>';
    echo '<div class="divCamera"><label for="fileToUpload"><img class="camera" src="./images/icones/camera.png"></label><input class="btnCamera" type="file" name="fileToUpload" id="fileToUpload"></div>';
    echo '</form></div>';
    echo '<div class="aCoteImage">';
    //Titre
    IF(isset($_GET['titre']) &&$_GET['titre'] != "" && !$row)
    {
        echo '<input name="titre2" type="text" value="'.$_GET['titre'].'" onchange="document.getElementById(\'titre\').value = this.value;">';
    }
    else 
    {
        if($row)
        {
            echo '<input name="titre2" type="text" value="'.$row[1].'"/>';
        }
        else
        {
            echo '<input name="titre2" type="text" value="Titre" onchange="document.getElementById(\'titre\').value = this.value;">';
        }
        
    }
    //Description
    IF(isset($_GET['description']) &&$_GET['description'] != "" && !$row)
    {
        echo '<textarea name="description2" rows="5" onchange="document.getElementById(\'description\').value = this.value;">'.$_GET['description'].'</textarea>';
    }
    else 
    {
        if($row)
        {
            echo '<textarea name="description2" rows="5">'.$row[2].'</textarea>';
        }
        else
        {
            echo '<textarea name="description2" rows="5" onchange="document.getElementById(\'description\').value = this.value;">Description</textarea>';
        }
        
    }
    //Duree
    IF(isset($_GET['duree']) &&$_GET['duree'] != "" && !$row)
    {
        echo '<input name="heure2" type="text" style="width:45%;" value="'.$_GET['duree'].'" onchange="document.getElementById(\'duree\').value = this.value;">';
    }
    else 
    {
        if($row)
        {
            echo '<input name="heure2" type="text" style="width:45%;" value="'.$row[3].'h"/>';
        }
        else
        {
            echo '<input name="heure2" type="text" style="width:45%;" value="Durée" onchange="document.getElementById(\'duree\').value = this.value;">';
        }
        
    }
    //Tarif
    IF(isset($_GET['montant']) &&$_GET['montant'] != "" && !$row)
    {
        echo '<input name="montant2" type="text" style="width:45%;" value="'.$_GET['montant'].'" onchange="document.getElementById(\'montant\').value = this.value;">';
    }
    else 
    {
        if($row)
        {
            echo '<input name="montant2" type="text" style="width:45%;" value="'.$row[4].'$"/>';
        }
        else
        {
            echo '<input name="montant2" type="text" style="width:45%;" value="Tarif" onchange="document.getElementById(\'montant\').value = this.value;">';
        }
        
    }
    
    echo '</div>';
    echo '<div style="text-align:right;vertical-align:bottom;"><input name="actif" style="vertical-align:bottom; width:10%" type="checkbox" value="1" checked><label for="activer">Activer le service dans le catalogue</label></div>';
    if($row)
    {
        echo '<div style="text-align:right"><input name="soumettre" onclick="modifierService(\''.addslashes($_GET['row']).'\')" type="submit" value="Confirmer" class="button"></div>';
    }
    else
    {
        echo '<div style="text-align:right"><input name="soumettre" onclick="ajouterService()" type="submit" value="Confirmer" class="button"></div>';
    }
    
    echo '</article2>';
}
if(isset($_GET['row']))
{
    $rowGet = explode("|",$_GET['row']);
    afficherUnePromo($rowGet);
}
else
{
    $nothing = false;
    afficherUnePromo($nothing);
}

?>
        
