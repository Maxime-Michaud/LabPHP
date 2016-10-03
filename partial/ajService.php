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
var_dump($_POST);
if($_POST['titre2'] != "Titre" && $_POST['titre2'] != "" )
{
   if($_POST['description2'] != "Description" && $_POST['description2'] != "")
   {
     if($_POST['heure2'] != "Durée" && $_POST['heure2'] != "")
     {
        if($_POST['montant2'] != "Tarif" && $_POST['montant2'] != "")
        {
            $query = "INSERT INTO `service`(`pk_service`, `service_titre`, `service_description`, `duree`, `tarif`, `actif`, `image`) VALUES (".returnPkService().",\"".$_POST['titre2']."\",\"".$_POST['description2']."\",".$_POST['heure2'].",".$_POST['montant2'].",".returnActif().",\"".getImageName($_POST['image'])."\");";
            echo $query;
            $rs = mysql_query($query);
            if(!$rs)
               echo 'L\'ajout de service a écouché, le champs durée doit être un entier et le champ montant doit être au format 11.11';
            return;
        }
     }
   }
}
echo 'L\'ajout de service a écouché, vérifier les champs';
?>

