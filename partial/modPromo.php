<?php
mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');

$row = explode("|",$_POST['row']);

$query= 'UPDATE `ta_promotion_service` SET `fk_promotion` = \''.$_POST['numPromo'].'\' WHERE `ta_promotion_service`.`pk_promotion_service` = '.$row[0];
$rs = mysql_query($query);

$query= 'UPDATE `ta_promotion_service` SET `date_fin` = \''.$_POST['date_fin'].'\' WHERE `ta_promotion_service`.`pk_promotion_service` = '.$row[0];
$rs = mysql_query($query);

$query= 'UPDATE `ta_promotion_service` SET `date_debut` = \''.$_POST['date_debut'].'\' WHERE `ta_promotion_service`.`pk_promotion_service` = '.$row[0];
$rs = mysql_query($query);

$query= 'UPDATE `ta_promotion_service` SET `code` = \''.$_POST['code'].'\' WHERE `ta_promotion_service`.`pk_promotion_service` = '.$row[0];
$rs = mysql_query($query);
?>

