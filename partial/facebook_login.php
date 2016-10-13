<!-- IMPORTANT: fait en équipe avec Philippe Normandin, code par: Philippe Normandin -->
<?php 

	$_SESSION["access_token"] = $_POST["access_token"];
    $_SESSION["email"] = $_POST["fb_email"];

	$fb_email_stmt = Queries::instance()->get("fb_login_email_qry");

	$fb_email_stmt->bind_param("s", $_POST["fb_email"]);
	$fb_email_stmt->bind_result($id, $admin);

	$fb_email_stmt->execute();
	$fb_email_stmt->store_result();
		
	if ($fb_email_stmt->fetch()){
			$_SESSION["user"] = $id;
			$_SESSION["admin"] = $admin;	
			header("Location: main.php");
			die();
	} else {
		header("Location: profil.php");
		die();
	}

?>

