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



<html>
    <head>
        <title>Panier</title>
        <meta charset="UTF-8">
        <link href="./styles/style.css" rel="stylesheet" type="text/css">
        <link href="./styles/services.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php 
            include('./includes/header.php'); 
            echo '<main>';

            for ($i = 1; $i <= $_SESSION["nbItemPanier"]; $i++) {
                afficherUnePromo($_SESSION[$i."a"]);
            }
            
            echo '</main>';
        ?>
        <div style="border:2px solid brown;width: 40%;display: inline-block;">Entrer le code promotinnel pour profiter d'un rabais additionnel
            <input type="text" style="width: 40%;"> <br>
            <input type="button" value="Valider" onclick="" class="button">
        </div>
        <div style="width: 45%;display: inline-block;">sous total: 400$ <br>
            rabais additionnel: 60$
            <hr style="border-top:1px solid orange">
            Total: 340$ <br>
            <hr style="border-top:1px solid orange">
        </div>
        <input style="float: right" type="button" value="Paiement" onclick="" class="button">
    </body>
    
</html>


