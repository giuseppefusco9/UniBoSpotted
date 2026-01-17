<?php
require_once 'bootstrap.php';

if(isUserLoggedIn() && isset($_POST["testo"]) && isset($_POST["post_id"])){
    
    $testo = trim($_POST["testo"]);
    $postId = $_POST["post_id"];
    $userId = $_SESSION["id"];

    if(!empty($testo)){
        $dbh->insertComment($postId, $userId, $testo);
        header("Location: index.php");
        exit;
    }
}

//Base Template
$templateParams["titolo"] = "UBSpotted - Home";
$templateParams["nome"] = "lista-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();
$templateParams["posts"] = $dbh->getPosts();

require 'template/base.php';
?>