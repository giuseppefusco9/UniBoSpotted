<?php
require_once 'bootstrap.php';

if(isset($_GET["formmsg"])){
    $templateParams["formmsg"] = htmlspecialchars($_GET["formmsg"]);
}

if(isUserLoggedIn()){
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
}


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

$templateParams["titolo"] = "UBSpotted - Home";
$templateParams["nome"] = "lista-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();
$templateParams["posts"] = $dbh->getPosts();

require 'template/base.php';
?>