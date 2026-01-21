<?php
require_once 'bootstrap.php';

if(isset($_POST["username"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["username"], $_POST["password"]);
    if(!$login_result){
        $templateParams["errorelogin"] = "Errore! Controllare username o password!";
    }
    else{
        registerLoggedUser($login_result);
        header("Location: login.php");
        exit;
    }
}

if(isUserLoggedIn()){
    $templateParams["titolo"] = "UBSpotted - User Home";
    $templateParams["username"] = $_SESSION["username"];
    $templateParams["nome"] = "login-home.php";
    $templateParams["userposts"] = $dbh->getPostsByAuthorId($_SESSION["id"]);

    $userId = $_SESSION['id']; 
    $stats = $dbh->getUserPostStats($userId);
    $labels = [];
    $data = [];
    foreach($stats as $row){
        $labels[] = $row['nome'];
        $data[] = $row['num_post'];
    }
    $templateParams["statisticheUser"]["labels"] = $labels;
    $templateParams["statisticheUser"]["data"] = $data;
    
    if(isset($_GET["formmsg"])){
        $templateParams["formmsg"] = $_GET["formmsg"];
    }
}
else{
    $templateParams["titolo"] = "UBSpotted - Login";
    $templateParams["nome"] = "login-form.php";
}
$templateParams["categorieTop"] = $dbh->getTopCategories();

require 'template/base.php';
?>