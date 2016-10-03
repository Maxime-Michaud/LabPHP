<?php

function returnPk(){
    $query = "SELECT MAX(pk_promotion_service) FROM ta_promotion_service;";
    $rs = mysql_query($query);
    $row = mysql_fetch_assoc($rs);
    return $row['MAX(pk_promotion_service)'] + 1;
}

mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');
var_dump($_POST);
if($_POST['date_debut'] != "date de début" && $_POST['date_debut'] != "" )
{
   if($_POST['date_fin'] != "date de fin" && $_POST['date_fin'] != "" )
   {
        if($_POST['numPromo'] != "")
        {
            $query = "INSERT INTO `ta_promotion_service` (`pk_promotion_service`, `fk_promotion`, `fk_service`, `date_debut`, `date_fin`, `code`) VALUES ('".returnPk()."','".$_POST['numPromo']."','".$_POST['fk_service']."','".$_POST['date_debut']."','".$_POST['date_fin']."','".$_POST['code']."')";
            echo $query;
            var_dump($_POST['fk_service']);
            $rs = mysql_query($query);
            if(!$rs)
               echo 'L\'ajout de promotion a écouché';
            return;
        }
   }
}
echo 'L\'ajout de promotion a écouché, vérifier les champs';
?>

