<?php
mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');
$query= 'DELETE FROM `ta_promotion_service` WHERE `ta_promotion_service`.`pk_promotion_service` ='.$_POST['id'].';';
$rs = mysql_query($query);
?>
