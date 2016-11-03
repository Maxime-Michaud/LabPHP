<?php
session_start();
    $_SESSION[$_SESSION["nbItemPanier"]."a"] = $_POST['row'];
    $_SESSION["nbItemPanier"]= $_SESSION["nbItemPanier"] + 1;
    var_dump($_SESSION);
