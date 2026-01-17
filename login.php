<?php
require_once 'bootstrap.php';

if(isset($_POST["username"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["username"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $templateParams["errorelogin"] = "Errore! Controllare username o password!";
    }
    else{
        registerLoggedUser($login_result[0]);
    }
}

if(isUserLoggedIn()){
    $templateParams["titolo"] = "UBSpotted - User Home";
    $templateParams["nome"] = "login-home.php";
    $templateParams["posts"] = $dbh->getPostsByAuthorId($_SESSION["id"]);
    if(isset($_GET["formmsg"])){
        $templateParams["formmsg"] = $_GET["formmsg"];
    }
}
else{
    $templateParams["titolo"] = "Blog TW - Login";
    $templateParams["nome"] = "login-form.php";
}
$templateParams["categorieTop"] = $dbh->getTopCategories();

require 'template/base.php';
?>