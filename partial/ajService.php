<?php
function getImageName($name)
{
    $pattern = '~.*\/(.*?\.(jpg|png|gif))~';
    preg_match($pattern, $name, $matches);
    return $matches[1];
}

function returnPkService(){
    $query = "SELECT MAX(pk_service) FROM service;";
    $rs = mysql_query($query);
    $row = mysql_fetch_assoc($rs);
    return $row['MAX(pk_service)'] + 1;
}

function returnActif(){
    if($_POST['actif'])
        return 1;
    else
        return 0;
}
mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');
if($_POST['titre'] != "Titre" && $_POST['titre'] != "" )
{
   if($_POST['description'] != "Description" && $_POST['description'] != "")
   {
     if($_POST['heure'] != "Durée" && $_POST['heure'] != "")
     {
         if($_POST['heure'] != "Durée" && $_POST['heure'] != "")
         {
             if($_POST['montant'] != "Tarif" && $_POST['montant'] != "")
             {
                 $query = "INSERT INTO `service`(`pk_service`, `service_titre`, `service_description`, `duree`, `tarif`, `actif`, `image`) VALUES (".returnPkService().",\"".$_POST['titre']."\",\"".$_POST['description']."\",".$_POST['heure'].",".$_POST['montant'].",".returnActif().",\"".getImageName($_POST['image'])."\");";
                 echo $query;
                 $rs = mysql_query($query);
                 var_dump($rs);
             }
         }
     }
   }
}
?>

