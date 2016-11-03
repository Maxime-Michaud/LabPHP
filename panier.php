<?php
session_start();

function getAfficherPromotion($numero, $prix){
    $query = "SELECT * FROM ta_promotion_service";
    $rs = mysql_query($query);
    while ($row = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        if($row["fk_service"] == $numero)
        {
            afficherUnRabais($row["fk_promotion"],$prix);
        }   
    }
}

function getAddRabais($numero, $prix){
    $query = "SELECT * FROM ta_promotion_service";
    $rs = mysql_query($query);
    $rabais = 0;
    while ($row = mysql_fetch_array($rs, MYSQL_ASSOC))
    {
        if($row["fk_service"] == $numero)
        {
            $rabais += trouverRabais($numero, $prix);
        }   
    }
    return $rabais;
}

function trouverRabais($numero, $prix)
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
    $deduction = $row["rabais"] * $prix; 
    return $deduction;
}

function afficherUnRabais($numero, $prix)
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
    $deduction = $row["rabais"] * $prix; 
    echo $row["promotion_titre"].'('.$rabais.'%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$deduction.'$<br>';
}

function &afficherUnePromo($row){
    $rowToString = explode("|",$row);
    echo '<article>';
    echo '<img class="cours" src="./images/services/'.$rowToString[6].'">';

    echo '<div class="reste">';
    echo "<div class='titre'>".$rowToString[1]."</div>";

    echo  '<div class="row"><div class="tarif">Tarif: '.$rowToString[4].'$'.'</div>';
    echo '</div>';
    getAfficherPromotion($rowToString[0],$rowToString[4]);
    echo '<div style="float:right"><u>Retirer</u></div>';
    echo '</article>';
    return $rowToString[4];
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
        $coutTotal = 0;
        $rabais = 0;
        $arrayDeId = array();
            include('./includes/header.php'); 
            echo '<main>';

            for ($i = 0; $i < $_SESSION["nbItemPanier"]; $i++) {
                $coutTotal += afficherUnePromo($_SESSION[$i."a"]);
                $rowToString = explode("|",$_SESSION[$i."a"]);
                $rabais = getAddRabais($rowToString[0],$rowToString[4]);
                $arrayDeId[$i] = $rowToString[0];
            }
            
            echo '</main>';
        
        echo '<div style="border:2px solid brown;width: 40%;display: inline-block;">Entrer le code promotinnel pour profiter d\'un rabais additionnel
            <input type="text" style="width: 40%;"> <br>
            <input type="button" value="Valider" onclick="" class="button">
        </div>
        <div style="width: 45%;display: inline-block;"
             >sous total:';
        echo $coutTotal.'$';
        echo '<br>
            rabais additionnel: '.$rabais.'$';
        echo    '<hr style="border-top:1px solid orange">';
        $total = $coutTotal - $rabais;
        echo 'Total: '.$total.'$ <br>
            <hr style="border-top:1px solid orange">
        </div>
        <input style="float: right" type="button" value="Paiement" onclick="" class="button">';
        var_dump($arrayDeId);
        echo '</body></html>'
?>


